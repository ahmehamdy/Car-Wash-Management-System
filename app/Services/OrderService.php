<?php

namespace App\Services;

use App\Models\CarWash;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Order;

class OrderService
{
    public function createOrder(User $user, CarWash $carWash, Carbon $pickup)
    {
        $order = $user->orders()->create([
            'car_wash_id' => $carWash->id,
            'status' => 'pending',
            'pickup_time' => $pickup,
            'total_price' => 0,
        ]);
        return $order;
    }

    public function attachService(Order $order, array $serviceData)
    {
        $services = Service::whereIn('id', collect($serviceData)->pluck('id'))->get()->keyBy('id');

        $syncData = [];
        $total = 0;

        foreach ($serviceData as $serviceRequest) {
            $service = $services[$serviceRequest['id']];
            $qty = $serviceRequest['qty'] ?? 1;
            $syncData[$service->id] = [
                'price' => $service->price,
                'qty' => $qty
            ];

            $total  += $qty * $service->price;
        }
        $order->services()->sync($syncData);

        $order->update(['total_price' => $total]);
        return $order->refresh();
    }

    public function updateOrderStatus(Order $order, string $newStatus)
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

        return $order->refresh();
    }
}
