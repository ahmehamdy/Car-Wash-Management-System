@extends('layouts.dashboard')

@section('title', 'لوحة التحكم - العميل')
@section('page-title', 'لوحة التحكم')

@section('content')
    <!-- Welcome Card -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-2">مرحباً {{ auth()->user()->name }}! 👋</h4>
                            <p class="mb-0">لديك {{ $activeOrdersCount ?? 0 }} طلبات نشطة</p>
                        </div>
                        <a href="{{ route('carWash.availableCarWashes') }}" class="btn btn-light">
                            <i class="bi bi-plus-circle"></i> حجز جديد
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted">نشطة</h6>
                            <h3 class="mb-0">{{ $activeOrdersCount ?? 0 }}</h3>
                        </div>
                        <div class="fs-2 text-primary">
                            <i class="bi bi-clock-history"></i>
                        </div>
                    </div>
                    <a href="{{ route('client.orders.index', ['status' => 'pending']) }}"
                        class="small text-decoration-none">عرض الكل →</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted">مكتملة</h6>
                            <h3 class="mb-0">{{ $completedOrdersCount ?? 0 }}</h3>
                        </div>
                        <div class="fs-2 text-success">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                    <a href="{{ route('client.orders.index', ['status' => 'completed']) }}"
                        class="small text-decoration-none">عرض الكل →</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted">مفضلة</h6>
                            <h3 class="mb-0">{{ $favoritesCount ?? 0 }}</h3>
                        </div>
                        <div class="fs-2 text-warning">
                            <i class="bi bi-heart"></i>
                        </div>
                    </div>
                    <a href="#" class="small text-decoration-none">عرض الكل →</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted">الرصيد</h6>
                            <h3 class="mb-0">{{ $walletBalance ?? 0 }}</h3>
                        </div>
                        <div class="fs-2 text-info">
                            <i class="bi bi-wallet2"></i>
                        </div>
                    </div>
                    <a href="#" class="small text-decoration-none">شحن ←</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Orders -->
    @if (isset($activeOrders) && $activeOrders->count() > 0)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">طلباتي النشطة</h5>
                        <a href="{{ route('client.orders.index') }}" class="btn btn-sm btn-outline-primary">عرض الكل</a>
                    </div>
                    <div class="card-body">
                        @foreach ($activeOrders as $order)
                            <div class="border-bottom pb-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <h6 class="mb-1">{{ $order->carwash->name ?? 'غير محدد' }}</h6>
                                        <small class="text-muted">
                                            @foreach ($order->services as $service)
                                                {{ $service->name }}@if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </small>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="fw-bold">{{ number_format($order->total_price) }} ر.س</span>
                                    </div>
                                    <div class="col-md-3">
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'accepted' => 'info',
                                                'in-progress' => 'primary',
                                                'completed' => 'success',
                                                'cancelled' => 'danger',
                                            ];
                                            $statusTexts = [
                                                'pending' => 'قيد الانتظار',
                                                'accepted' => 'مقبول',
                                                'in-progress' => 'قيد التنفيذ',
                                                'completed' => 'مكتمل',
                                                'cancelled' => 'ملغي',
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                            {{ $statusTexts[$order->status] ?? $order->status }}
                                        </span>
                                    </div>
                                    <div class="col-md-3 text-md-end">
                                        <a href="{{ route('client.order.showMyOrder', $order->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> التفاصيل
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Recent Orders -->
    @if (isset($recentOrders) && $recentOrders->count() > 0)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">آخر الطلبات</h5>
                        <a href="{{ route('client.orders.index') }}" class="btn btn-sm btn-outline-primary">عرض الكل</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>رقم الطلب</th>
                                        <th>المغسلة</th>
                                        <th>التاريخ</th>
                                        <th>المبلغ</th>
                                        <th>الحالة</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentOrders as $order)
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'accepted' => 'info',
                                                'in-progress' => 'primary',
                                                'completed' => 'success',
                                                'cancelled' => 'danger',
                                            ];
                                            $statusTexts = [
                                                'pending' => 'قيد الانتظار',
                                                'accepted' => 'مقبول',
                                                'in-progress' => 'قيد التنفيذ',
                                                'completed' => 'مكتمل',
                                                'cancelled' => 'ملغي',
                                            ];
                                        @endphp
                                        <tr>
                                            <td>#{{ $order->order_number ?? $order->id }}</td>
                                            <td>{{ $order->carwash->name ?? 'غير محدد' }}</td>
                                            <td>{{ $order->created_at->format('Y/m/d') }}</td>
                                            <td>{{ number_format($order->total_price) }} ر.س</td>
                                            <td>
                                                <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                                    {{ $statusTexts[$order->status] ?? $order->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('client.order.showMyOrder', $order->id) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Empty State -->
    @if ((!isset($recentOrders) || $recentOrders->count() == 0) && (!isset($activeOrders) || $activeOrders->count() == 0))
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-inbox fs-1 text-muted"></i>
                        <h5 class="mt-3">لا توجد طلبات حالياً</h5>
                        <p class="text-muted">ابدأ بحجز خدمة جديدة من المغاسل المتاحة</p>
                        <a href="{{ route('carWash.availableCarWashes') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> تصفح المغاسل
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
