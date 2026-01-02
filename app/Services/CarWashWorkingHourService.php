<?php

namespace App\Services;

use App\Models\CarWash;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class CarWashWorkingHourService
{
    public function addWorkingHours(CarWash $carWash, array $days, $open_time, $close_time)
    {
        $carWash->workingHours()->delete();
        foreach ($days as $day) {
            $carWash->workingHours()->create([
                'day' => strtolower($day),
                'open_time' => $open_time,
                'close_time' => $close_time,
            ]);
        }
    }

}
