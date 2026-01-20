<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarWash;

class ClientHomeController extends Controller
{
    public function home()
    {
        $carWashes = CarWash::where('is_active', true)->get();
        return view('client.dashboard', compact('carWashes'));
    }

    public function availableCarWashes()
    {
        $carWashes = CarWash::where('is_active', true)->get();
        return view('client.carWashes', compact('carWashes'));
    }

    public function listMyOrders()
    {
        $orders = auth()->user()->orders()->latest()->get();
        return view('client.orders',compact('orders'));
    }

}
