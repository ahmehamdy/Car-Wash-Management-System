<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'car_wash_id',
        'total_price',
        'status',
        'pickup_time',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function carWash()
    {
        return $this->belongsTo(CarWash::class);
    }
    public function services()
    {
        return $this->belongsToMany(Service::class)->withPivot(['price', 'qty'])->withTimestamps();
    }
    public function rating()
    {
        return $this->hasOne(Rating::class);
    }
}
