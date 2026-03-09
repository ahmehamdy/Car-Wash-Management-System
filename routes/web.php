<?php

use App\Http\Controllers\CarWashController;
use App\Http\Controllers\CarWashWorkingHourController;
use App\Http\Controllers\ClientHomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role == 'owner') {
            return redirect()->route('owner.dashboard');
        } else {
            return redirect()->route('client.home');
        }
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('car-wash-working-hours')->name('car-wash-working-hours.')->group(function () {
        Route::get('/car-wash/{carWash}/working-hours', [CarWashWorkingHourController::class, 'index'])->name('index');
        Route::get('/car-wash/{carWash}/working-hours/{workingHour}/edit', [CarWashWorkingHourController::class, 'edit'])->name('edit');
        Route::put('/car-wash/{carWash}/working-hours/{workingHour}/update', [CarWashWorkingHourController::class, 'update'])->name('update');
    });
});


Route::middleware(['auth', 'role:owner'])->group(function () {

    Route::get('/owner-dashboard', [OwnerDashboardController::class, 'index'])->name('owner.dashboard');
    Route::prefix('carwash')->group(function () {

        Route::get('/', [CarWashController::class, 'index'])->name('carwashes.index');
        Route::get('/create', [CarWashController::class, 'create'])->name('carWash.create');
        Route::post('/', [CarWashController::class, 'store'])->name('carWash.store');
        Route::get('/{carWash}', [CarWashController::class, 'show'])->name('carWash.show');
        Route::get('/{carWash}/edit', [CarWashController::class, 'edit'])->name('carWash.edit');
        Route::put('/{carWash}', [CarWashController::class, 'update'])->name('carWash.update');
        Route::delete('/{carWash}', [CarWashController::class, 'destroy'])->name('carWash.destroy');

        Route::get('/orders/{carWash}', [OrderController::class, 'selectStatus'])->name('carWash.orders.selectStatus');
        Route::get('/orders/{carWash}/status/{status}', [OrderController::class, 'showCarwashOrder'])->name('carWash.orders.index');
        Route::patch('/orders/{order}', [OrderController::class, 'updateStatus'])->name('carWash.orders.updateStatus'); 
    });


    Route::prefix('service')->group(function () {
        Route::get('/{carWash}', [ServiceController::class, 'index'])->name('services.index');
        Route::get('/craete/{carWash}', [ServiceController::class, 'create'])->name('services.create');
        Route::post('/{carWash}', [ServiceController::class, 'store'])->name('services.store');
        Route::get('/{carWash}/edit/{service}', [ServiceController::class, 'edit'])->name('services.edit');
        Route::put('/{carWash}/update/{service}', [ServiceController::class, 'update'])->name('services.update');
        Route::delete('/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
    });
});


Route::middleware(['auth', 'role:client'])->group(function () {

    Route::get('/client', [ClientHomeController::class, 'home'])->name('client.home');
    Route::get('/getAvailable', [ClientHomeController::class, 'availableCarWashes'])->name('carWash.availableCarWashes');
    Route::get('/clientOrder', [ClientHomeController::class, 'listMyOrders'])->name('client.listMyOrders');

    Route::prefix('clientOrder')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('client.orders.index');
        Route::get('/create/{carWash}', [OrderController::class, 'create'])->name('client.orders.create');
        Route::get('/edit/{order}', [OrderController::class, 'edit'])->name('client.order.edit');
        Route::post('/{carWash}', [OrderController::class, 'store'])->name('client.order.store');
        Route::get('/{order}', [OrderController::class, 'showMyOrder'])->name('client.order.showMyOrder');
        Route::put('/{order}', [OrderController::class, 'updateMyOrder'])->name('client.order.updateMyOrder');
        Route::delete('/{order}', [OrderController::class, 'deleteMyOrder'])->name('client.order.deleteMyOrder');
    });
});
require __DIR__ . '/auth.php';
