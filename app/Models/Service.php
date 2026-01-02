<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'car_wash_id',
        'name',
        'price',
    ];



    public function carWash()
    {
        return $this->belongsTo(CarWash::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot(['price', 'qty'])->withTimestamps();
    }
}
