<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Order;
use App\Models\CarWash;
use App\Models\CarWashWorkingHour;
use App\Policies\OrderPolicy;
use App\Policies\CarWashPolicy;
use App\Policies\CarWashWorkingHourPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Order::class => OrderPolicy::class,
        CarWash::class => CarWashPolicy::class,
        CarWashWorkingHour::class => CarWashWorkingHourPolicy::class,
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
