<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarWashRequest;
use App\Http\Requests\UpdateCarWashRequest;
use App\Models\CarWash;
use App\Services\CarWashServices;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class CarWashController extends Controller
{
    public function __construct(
        private CarWashServices $carWashServices
    ) {}
    use AuthorizesRequests;
    public function index()
    {
        $carWashes = auth()->user()->carWashes()->paginate(6);

        return view('owner.carwashes.index', compact('carWashes'));
    }

    public function create()
    {
        return view('owner.carwashes.create');
    }

    public function store(StoreCarWashRequest $request)
    {
        $request->validated();

        $this->carWashServices->craeteCarWash($request);
        return redirect()->route('carwash.index')->with('success', 'Car Wash Created Successfully');
    }

    public function show(CarWash $carWash)
    {
        $this->authorize('view', $carWash);

        // إحصائيات الطلبات
        $pendingOrders = $carWash->orders()->where('status', 'pending')->count();
        $inProgressOrders = $carWash->orders()->where('status', 'in-progress')->count();
        $completedOrders = $carWash->orders()->where('status', 'completed')->count();
        $cancelledOrders = $carWash->orders()->where('status', 'cancelled')->count();

        // إجمالي الإيرادات
        $totalRevenue = $carWash->orders()
            ->where('status', 'completed')
            ->sum('total_price');

        // آخر الطلبات
        $recentOrders = $carWash->orders()
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        // ألوان الحالات للنصوص
        $statusColors = [
            'pending' => 'warning',
            'confirmed' => 'info',
            'in-progress' => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger'
        ];

        $statusText = [
            'pending' => 'قيد الانتظار',
            'confirmed' => 'مقبولة',
            'in-progress' => 'قيد التنفيذ',
            'completed' => 'مكتملة',
            'cancelled' => 'ملغية'
        ];

        return view('owner.carwashes.show', compact(
            'carWash',
            'pendingOrders',
            'inProgressOrders',
            'completedOrders',
            'cancelledOrders',
            'totalRevenue',
            'recentOrders',
            'statusColors',
            'statusText'
        ));
    }


    public function edit(CarWash $carWash)
    {
        return view('owner.carwashes.edit', compact('carWash'));
    }

    public function update(UpdateCarWashRequest $request, CarWash $carWash)
    {
        $request->validated();
        $this->carWashServices->updateCarWash($request,$carWash);
        return redirect()->route('carwashes.index')->with('success', 'Car Wash updated Successfully');
    }

    public function destroy(CarWash $carWash)
    {
        $this->authorize('delete', $carWash);
        $carWash->delete();
        return redirect()->route('carwashes.index')->with('success', 'Car Wash deleted Successfully');
    }
}
