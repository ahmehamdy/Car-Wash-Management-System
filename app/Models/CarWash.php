<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarWash extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'phone',
        'address',
        'lat',
        'lng',
        'is_active',
        'images',
    ];

    protected $casts = [
        'images'=>'array'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function services()
    {
        return $this->hasMany(Service::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function workingHours()
    {
        return $this->hasMany(CarWashWorkingHour::class);
    }
}
