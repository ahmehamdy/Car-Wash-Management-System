<?php

namespace App\Policies;

use App\Models\CarWashWorkingHour;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CarWashWorkingHourPolicy
{
    use HandlesAuthorization;

    public function update(User $user, CarWashWorkingHour $workingHour)
    {
        return $user->id === $workingHour->carWash->user_id;
    }
}
