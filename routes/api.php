<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarWashController;
use App\Http\Controllers\Api\CarWashWorkingHourController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Mail;
use App\Mail\NewOrderForCarWash;
use App\Models\Order;

Route::get('/test-mail', function () {
    $order = Order::first(); 
    if (!$order) {
        return 'No orders found';
    }

    Mail::to($order->carWash->user->email)
        ->queue(new NewOrderForCarWash($order));

    return 'Test email sent!';
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    Route::delete('/logout', [AuthController::class, 'logout']);
    Route::middleware('role:owner')->group(function () {

        Route::prefix('carwash')->group(function () {
            Route::post('/', [CarWashController::class, 'store'])->name('carwash.strore');
            Route::get('/{carWash}', [CarWashController::class, 'show'])->name('carwash.show');
            Route::put('/{carWash}', [CarWashController::class, 'update'])->name('carwash.update');
            Route::delete('/{carWash}', [CarWashController::class, 'destroy'])->name('carwash.destroy');
        });
        Route::prefix('service')->group(function () {
            Route::post('/carwash/{carwash}', [ServiceController::class, 'store'])->name('service.strore');
            Route::put('/{service}', [ServiceController::class, 'update'])->name('service.update');
            Route::delete('/{service}', [ServiceController::class, 'destroy'])->name('service.destroy');
        });
        Route::prefix('carwashOrder')->group(function () {
            Route::get('/{carWash}', [OrderController::class, 'showCarwashOrder'])->name('order.showCarwashOrder');
            Route::patch('/{order}', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
        });
        Route::post('/workHours/{carWash}', [CarWashWorkingHourController::class, 'store'])->name('WorkHour.store');
    });
    Route::middleware('role:client')->group(function () {

        Route::prefix('clientOrder')->group(function () {
            Route::post('/{carWash}', [OrderController::class, 'store'])->name('order.store');
            Route::get('/{order}', [OrderController::class, 'showMyOrder'])->name('order.showMyOrder');
            Route::put('/{order}', [OrderController::class, 'updateMyOrder'])->name('order.updateMyOrder');
            Route::delete('/{order}', [OrderController::class, 'deleteMyOrder'])->name('order.deleteMyOrder');
        });
        Route::post('/rating/{order}', [RatingController::class, 'addRating'])->name('rating.addRating');
    });
});
