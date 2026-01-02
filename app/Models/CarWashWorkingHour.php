<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarWashWorkingHour extends Model
{
    protected $fillable = [
        'car_wash_id',
        'day',
        'open_time',
        'close_time'

    ];

    public function carWash()
    {
        return $this->belongsTo(CarWash::class);
    }
}
