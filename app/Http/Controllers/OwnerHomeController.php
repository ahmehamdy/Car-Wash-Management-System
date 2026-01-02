<?php

namespace App\Http\Controllers;

use App\Models\CarWash;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;

class OwnerHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['service', 'car_wash'])
        ->where('car_wash_id', auth()->user()->carWashes()->first()->id)->get();
        $services = Service::where('car_wash_id',auth()->user()->carWashes()->first()->id)->get();
        $carWash = CarWash::where('user_id',auth()->user()->id)->first();
        return view('owner.home',compact('orders','services','carWash'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
