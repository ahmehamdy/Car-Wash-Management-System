<?php

use App\Http\Controllers\CarWashController;
use App\Http\Controllers\ClientHomeController;
use App\Http\Controllers\OwnerHomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/clienthome', [ClientHomeController::class, 'index'])->name('client.home');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth','role:car_wash'])->group(function () {

    Route::get('/ownerhome', [OwnerHomeController::class, 'index'])->name('owner.home');

    Route::prefix('carwash')->group(function(){
        Route::get('/',[CarWashController::class,'index'])->name('carwash.index');
        Route::post('/',[CarWashController::class,'store'])->name('carwash.store');
        Route::get('/{id}/edit',[CarWashController::class,'edit'])->name('carwash.edit');
        Route::get('/create',[CarWashController::class,'create'])->name('carwash.create');
        Route::put('/{id}',[CarWashController::class,'update'])->name('carwash.update');
        Route::delete('/{id}',[CarWashController::class,'destroy'])->name('carwash.destroy');
    });
});

require __DIR__ . '/auth.php';
