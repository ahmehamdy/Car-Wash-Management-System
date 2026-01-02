<?php

namespace App\Services;

use App\Models\CarWash;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use App\Mail\OrderConfirmedForUser;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewOrderForCarWash;

class OrderService
{

    public function createOrder(User $user, string $pickup_time, CarWash $carWash, array $servicesData)
    {
        $carWash->loadMissing('workingHours');

        $pickup = Carbon::createFromFormat('Y-m-d H:i', $pickup_time);

        $workingHours = $carWash->workingHours()->where('day', strtolower($pickup->englishDayOfWeek))->first();

        $oldPickup = $user->orders()->where('pickup_time', $pickup_time)->exists();

        if ($pickup->lt(now())) {
            throw ValidationException::withMessages([
                'pickup_time' => ['Pickup time cannot be in the past']
            ]);
        }
        if (!$workingHours) {
            throw ValidationException::withMessages([
                'pickup_time' => ['Car wash is closed on this day']
            ]);
        }
        if ($pickup->format('H:i') < $workingHours->open_time || $pickup->format('H:i') >= $workingHours->close_time) {

            throw ValidationException::withMessages([
                'pickup_time' => ["Available from {$workingHours->open_time} to {$workingHours->close_time}"]
            ]);
        }

        if ($oldPickup) {
            throw ValidationException::withMessages([
                'pickup_time' => ['you have order in this time']
            ]);
        }

        $order = DB::transaction(function () use ($user, $carWash, $servicesData, $pickup) {

            $order = $user->orders()->create([
                'car_wash_id' => $carWash->id,
                'status' => 'pending',
                'pickup_time' => $pickup,
                'total_price' => 0,
            ]);

            $total = 0;
            $services = Service::whereIn('id', collect($servicesData)->pluck('id'))->get()->keyBy('id');

            foreach ($servicesData as $serviceRequest) {
                $service = $services[$serviceRequest['id']];
                $qty = $serviceRequest['qty'] ?? 1;

                $order->services()->attach($service->id, [
                    'price' => $service->price,
                    'qty' => $qty,
                ]);

                $total += $service->price * $qty;
            }

            $order->update(['total_price' => $total]);

            return $order;
        });
        Mail::to($order->carWash->user->email)->send(new NewOrderForCarWash($order));

        return $order->refresh();
    }

    public function updateStatus(Order $order, $newStatus)
    {
        $allawedtransform = [
            'pending' => ['confirmed', 'cancelled'],
            'confirmed' => ['completed']
        ];

        if (!in_array($newStatus, $allawedtransform[$order->status] ?? [])) {
            return response()->json([
                'message' => 'cannot do this update '
            ]);
        }

        $order->update([
            'status' => $newStatus
        ]);

        Mail::to($order->user->email)->send(new OrderConfirmedForUser($order));

        return $order->refresh();
    }

    public function updateMyOrder(Order $order, array $servicesData, string $pickup_time)
    {

        $carWash = CarWash::where('id', $order->car_wash_id)->firstOrFail();
        $pickup = Carbon::createFromFormat('Y-m-d H:i', $pickup_time);
        $workingHours = $carWash->workingHours()->where('day', strtolower($pickup->englishDayOfWeek))->first();
        $oldPickup = $carWash->orders()
            ->where('user_id', $order->user_id)
            ->where('pickup_time', $pickup_time)
            ->where('id', '!=', $order->id)
            ->exists();

        if ($pickup->lt(now())) {
            throw ValidationException::withMessages([
                'pickup_time' => ['Pickup time cannot be in the past']
            ]);
        }
        if (!$workingHours) {
            throw ValidationException::withMessages([
                'pickup_time' => ['Car wash is closed on this day']
            ]);
        }
        if ($pickup->format('H:i:s') < $workingHours->open_time || $pickup->format('H:i:s') >= $workingHours->close_time) {

            throw ValidationException::withMessages([
                'pickup_time' => ["Available from {$workingHours->open_time} to {$workingHours->close_time}"]
            ]);
        }

        if ($oldPickup) {
            throw ValidationException::withMessages([
                'pickup_time' => ['you have order in this time']
            ]);
        }
        DB::transaction(function () use ($order, $servicesData, $pickup_time) {

            $services = Service::whereIn('id', collect($servicesData)->pluck('id'))->get()->keyBy('id');

            $syncData = [];
            $total = 0;

            foreach ($servicesData as $serviceRequest) {
                $service = $services[$serviceRequest['id']];
                $qty = $serviceRequest['qty'] ?? 1;
                $syncData[$service->id] = [
                    'price' => $service->price,
                    'qty' => $qty
                ];

                $total  += $qty * $service->price;
            }

            $order->services()->sync($syncData);
            $order->update([
                'total_price' => $total,
                'pickup_time' => $pickup_time
            ]);
        });

        return $order->refresh();
    }
}
