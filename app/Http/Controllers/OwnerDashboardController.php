<?php

namespace App\Http\Controllers;

use App\Models\CarWash;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        $owner = auth()->user();

        // جلب أول مغسلة للمالك (أو null إذا لم يكن لديه)
        $carWash = $owner->carWashes()->first();

        // الإحصائيات الرئيسية
        $totalCarWashes = $owner->carWashes()->count();

        // الطلبات (إذا كان لديه مغسلة)
        $totalOrders = 0;
        $totalRevenue = 0;
        $recentOrders = collect();
        $ordersByStatus = [
            'pending' => 0,
            'confirmed' => 0,
            'in-progress' => 0,
            'completed' => 0
        ];

        if ($carWash) {
            $totalOrders = Order::where('car_wash_id', $carWash->id)->count();
            $totalRevenue = Order::where('car_wash_id', $carWash->id)
                ->where('status', 'completed')
                ->sum('total_price');

            // الطلبات الحديثة (آخر 5)
            $recentOrders = Order::where('car_wash_id', $carWash->id)
                ->with(['user', 'carWash'])
                ->latest()
                ->take(5)
                ->get();

            // الطلبات حسب الحالة
            foreach (['pending', 'accepted', 'in-progress', 'completed'] as $status) {
                $ordersByStatus[$status] = Order::where('car_wash_id', $carWash->id)
                    ->where('status', $status)
                    ->count();
            }
        }

        return view('owner.dashboard', compact(
            'totalCarWashes',
            'totalOrders',
            'totalRevenue',
            'recentOrders',
            'ordersByStatus',
            'carWash'  // أضفنا carWash هنا
        ));
    }
}
