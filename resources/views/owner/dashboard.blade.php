@extends('layouts.dashboard')

@section('title', 'لوحة تحكم صاحب المغسلة')
@section('page-title', 'لوحة التحكم')

@section('content')
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-primary border-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <div class="text-muted fw-semibold">مغاسلي</div>
                            <div class="fs-4 fw-bold">{{ $totalCarWashes }}</div>
                        </div>
                        <div class="col-3 text-end">
                            <i class="bi bi-building fs-1 text-primary"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('carwashes.index') }}" class="text-decoration-none">
                            عرض التفاصيل <i class="bi bi-arrow-left"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-success border-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <div class="text-muted fw-semibold">إجمالي الطلبات</div>
                            <div class="fs-4 fw-bold">{{ $totalOrders }}</div>
                        </div>
                        <div class="col-3 text-end">
                            <i class="bi bi-receipt fs-1 text-success"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('carWash.orders.selectStatus', $carWash) }}" class="text-decoration-none">
                            إدارة الطلبات <i class="bi bi-arrow-left"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-warning border-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <div class="text-muted fw-semibold">إجمالي الإيرادات</div>
                            <div class="fs-4 fw-bold">{{ number_format($totalRevenue) }} ر.س</div>
                        </div>
                        <div class="col-3 text-end">
                            <i class="bi bi-currency-dollar fs-1 text-warning"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-success">+12% عن الشهر الماضي</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-info border-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <div class="text-muted fw-semibold">معدل الرضا</div>
                            <div class="fs-4 fw-bold">4.8/5</div>
                        </div>
                        <div class="col-3 text-end">
                            <i class="bi bi-star fs-1 text-info"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-success">+0.2 عن الشهر الماضي</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">الطلبات حسب الحالة</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <div class="list-group-item border-0 d-flex justify-content-between align-items-center">
                            <span class="badge bg-warning rounded-pill p-2">قيد الانتظار</span>
                            <span class="fw-bold">{{ $ordersByStatus['pending'] ?? 0 }}</span>
                        </div>
                        <div class="list-group-item border-0 d-flex justify-content-between align-items-center">
                            <span class="badge bg-info rounded-pill p-2">مقبولة</span>
                            <span class="fw-bold">{{ $ordersByStatus['accepted'] ?? 0 }}</span>
                        </div>
                        <div class="list-group-item border-0 d-flex justify-content-between align-items-center">
                            <span class="badge bg-primary rounded-pill p-2">قيد التنفيذ</span>
                            <span class="fw-bold">{{ $ordersByStatus['in-progress'] ?? 0 }}</span>
                        </div>
                        <div class="list-group-item border-0 d-flex justify-content-between align-items-center">
                            <span class="badge bg-success rounded-pill p-2">مكتملة</span>
                            <span class="fw-bold">{{ $ordersByStatus['completed'] ?? 0 }}</span>
                        </div>
                    </div>
                    <div class="mt-3 text-center">
                        @if (isset($carWash) && $carWash)
                            <a href="{{ route('carWash.orders.selectStatus', $carWash) }}"
                                class="btn btn-outline-primary btn-sm">
                                عرض جميع الطلبات
                            </a>
                        @else
                            <a href="#" class="btn btn-outline-primary btn-sm disabled">
                                أضف مغسلة أولاً
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">أحدث الطلبات</h5>
                    @if (isset($carWash) && $carWash)
                        <a href="{{ route('carWash.orders.selectStatus', $carWash) }}"
                            class="btn btn-sm btn-outline-primary">
                            عرض الكل
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    @if (isset($recentOrders) && $recentOrders->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>رقم الطلب</th>
                                        <th>العميل</th>
                                        <th>المغسلة</th>
                                        <th>المبلغ</th>
                                        <th>الحالة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentOrders as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->user->name ?? 'عميل' }}</td>
                                            <td>{{ $order->carWash->name ?? 'مغسلة' }}</td>
                                            <td>{{ number_format($order->total_price) }} ر.س</td>
                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'warning',
                                                        'accepted' => 'info',
                                                        'in-progress' => 'primary',
                                                        'completed' => 'success',
                                                        'cancelled' => 'danger',
                                                    ];
                                                    $statusText = [
                                                        'pending' => 'قيد الانتظار',
                                                        'accepted' => 'مقبول',
                                                        'in-progress' => 'قيد التنفيذ',
                                                        'completed' => 'مكتمل',
                                                        'cancelled' => 'ملغى',
                                                    ];
                                                @endphp
                                                <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                                    {{ $statusText[$order->status] ?? $order->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-receipt fs-1 text-muted"></i>
                            <p class="mt-2 text-muted">لا توجد طلبات حديثة</p>
                            @if (!isset($carWash))
                                <p class="text-muted small">قم بإضافة مغسلة أولاً لبدء استقبال الطلبات</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">إجراءات سريعة</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <a href="{{ route('carWash.create') }}" class="btn btn-outline-primary w-100 h-100 py-3">
                                <i class="bi bi-plus-circle d-block fs-1 mb-2"></i>
                                إضافة مغسلة
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            @if (isset($carWash) && $carWash)
                                <a href="{{ route('carWash.orders.selectStatus', $carWash) }}"
                                    class="btn btn-outline-success w-100 h-100 py-3">
                                    <i class="bi bi-receipt d-block fs-1 mb-2"></i>
                                    إدارة الطلبات
                                </a>
                            @else
                                <a href="#" class="btn btn-outline-success w-100 h-100 py-3 disabled">
                                    <i class="bi bi-receipt d-block fs-1 mb-2"></i>
                                    إدارة الطلبات
                                </a>
                            @endif
                        </div>
                        <div class="col-md-3 col-6">
                            @if (isset($carWash) && $carWash)
                                <a href="{{ route('services.index', $carWash) }}"
                                    class="btn btn-outline-warning w-100 h-100 py-3">
                                    <i class="bi bi-bucket d-block fs-1 mb-2"></i>
                                    إدارة الخدمات
                                </a>
                            @else
                                <a href="#" class="btn btn-outline-warning w-100 h-100 py-3 disabled">
                                    <i class="bi bi-bucket d-block fs-1 mb-2"></i>
                                    إدارة الخدمات
                                </a>
                            @endif
                        </div>
                        <div class="col-md-3 col-6">
                            @if (isset($carWash) && $carWash)
                                <a href="{{ route('car-wash-working-hours.index', $carWash) }}"
                                    class="btn btn-outline-info w-100 h-100 py-3">
                                    <i class="bi bi-clock d-block fs-1 mb-2"></i>
                                    مواعيد العمل
                                </a>
                            @else
                                <a href="#" class="btn btn-outline-info w-100 h-100 py-3 disabled">
                                    <i class="bi bi-clock d-block fs-1 mb-2"></i>
                                    مواعيد العمل
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
