<?php

namespace App\Services;

use App\Models\CarWash;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class PickupValidationService
{

    public function validate(CarWash $carWash, User $user, Carbon $pickup)
    {

        $carWash->loadMissing('workingHours');

        $workingHours = $carWash->workingHours()->where('day', strtolower($pickup->englishDayOfWeek))->first();

        $oldPickup = $user->orders()->where('pickup_time', $pickup)->exists();

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
        return true;
    }
}
