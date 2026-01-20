<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\CarWash;
use App\Models\Service;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ServiceController extends Controller
{
    use AuthorizesRequests;
    public function index(CarWash $carWash)
    {
        $this->authorize('view', $carWash);
        $services = $carWash->services()
            ->withCount('orders')
            ->latest()
            ->get();

        return view('owner.service.index', compact('services', 'carWash'));
    }

    public function create(CarWash $carWash)
    {
        $this->authorize('update', $carWash);
        return view('owner.service.create', compact('carWash'));
    }

    public function store(StoreServiceRequest $request, CarWash $carWash)
    {
        $validated = $request->validated();

        $service = $carWash->services()->create($validated);

        return redirect()->route('services.index', $carWash)->with('success', 'service added successfully');
    }

    public function edit(CarWash $carWash, Service $service)
    {
        $this->authorize('update', $carWash);
        return view('owner.service.update', compact('service', 'carWash'));
    }

    public function update(UpdateServiceRequest $request, CarWash $carWash, Service $service)
    {
        $this->authorize('update', $carWash);
        $validate = $request->validated();

        $service->update($validate);

        return redirect()->route('services.index', $carWash)
            ->with('success', 'تم تحديث الخدمة بنجاح');
    }

    public function show(CarWash $carWash, Service $service)
    {
        $this->authorize('view', $carWash);

        // تحميل عدد الطلبات
        $service->loadCount('orders');

        // حساب إجمالي الإيرادات من هذه الخدمة
        $totalRevenue = $service->orders()->sum('total_price');

        // الحصول على آخر الطلبات لهذه الخدمة
        $recentOrders = $service->orders()
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        // أسماء التصنيفات
        $categoryNames = [
            'washing' => 'غسيل',
            'polishing' => 'تلميع',
            'cleaning' => 'تنظيف داخلي',
            'engine' => 'تنظيف الموتور',
            'other' => 'خدمات أخرى'
        ];

        // ألوان الحالات
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

        return view('owner.services.show', compact(
            'carWash',
            'service',
            'totalRevenue',
            'recentOrders',
            'categoryNames',
            'statusColors',
            'statusText'
        ));
    }

    public function destroy(Service $service)
    {
        $this->authorize('delete', $service->carWash);

        $service->delete();

        return redirect()->back()->with('delete', 'service deleted successfully');
    }
}
