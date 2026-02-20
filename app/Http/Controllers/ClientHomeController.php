<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarWash;
use App\Models\Order;

class ClientHomeController extends Controller
{
    public function home()
    {
        $userId = auth()->id();

        $activeOrdersCount = Order::where('user_id', $userId)
            ->whereIn('status', ['pending', 'confirmed', 'in-progress'])
            ->count();

        $completedOrdersCount = Order::where('user_id', $userId)
            ->where('status', 'completed')
            ->count();

        $activeOrders = Order::with('carwash', 'services')
            ->where('user_id', $userId)
            ->whereIn('status', ['pending', 'accepted', 'in-progress'])
            ->latest()
            ->take(5)
            ->get();

        $recentOrders = Order::with('carwash')
            ->where('user_id', $userId)
            ->latest()
            ->take(10)
            ->get();

        return view('client.dashboard', compact(
            'activeOrdersCount',
            'completedOrdersCount',
            'activeOrders',
            'recentOrders'
        ));
    }

    public function availableCarWashes()
    {
        $carWashes = CarWash::where('is_active', true)->get();
        return view('client.carwashes.index', compact('carWashes'));
    }

    public function listMyOrders()
    {
        $orders = Order::with('carwash')
                      ->where('user_id', auth()->id())
                      ->latest()
                      ->paginate(15);

        return view('client.order.list', compact('orders'));
    }
}
