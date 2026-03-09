@extends('layouts.dashboard')

@section('title', 'آخر الطلبات')
@section('page-title', 'آخر الطلبات')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <p class="text-muted">نظرة عامة على آخر طلباتك</p>
                <a href="{{ route('carWash.availableCarWashes') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> طلب جديد
                </a>
            </div>
        </div>
    </div>

    <!-- إحصائيات سريعة -->
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-2">إجمالي الطلبات</h6>
                            <h3 class="mb-0">{{ $totalOrders ?? 0 }}</h3>
                        </div>
                        <i class="bi bi-bag fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-2">قيد الانتظار</h6>
                            <h3 class="mb-0">{{ $pendingOrders ?? 0 }}</h3>
                        </div>
                        <i class="bi bi-hourglass-split fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-2">قيد التنفيذ</h6>
                            <h3 class="mb-0">{{ $inProgressOrders ?? 0 }}</h3>
                        </div>
                        <i class="bi bi-gear fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-2">مكتملة</h6>
                            <h3 class="mb-0">{{ $completedOrders ?? 0 }}</h3>
                        </div>
                        <i class="bi bi-check-circle fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- آخر الطلبات -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">آخر الطلبات</h5>
                    <a href="{{ route('client.orders.index') }}" class="btn btn-sm btn-link">عرض الكل <i
                            class="bi bi-arrow-left"></i></a>
                </div>
                <div class="card-body">
                    @if (isset($recentOrders) && $recentOrders->count() > 0)
                        @foreach ($recentOrders as $order)
                            <div class="order-item p-3 border-bottom">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="bg-light rounded-circle p-3">
                                            @php
                                                $icons = ['bi-droplet', 'bi-car-front', 'bi-brush', 'bi-water'];
                                                $randomIcon = $icons[array_rand($icons)];
                                            @endphp
                                            <i class="bi {{ $randomIcon }} fs-4 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">{{ $order->carwash->name ?? 'مغسلة غير محددة' }}</h6>
                                                <p class="mb-0 text-muted small">
                                                    <i class="bi bi-calendar3"></i>
                                                    {{ $order->created_at->format('d F Y') }} |
                                                    <i class="bi bi-tag"></i>
                                                    @foreach ($order->services as $service)
                                                        {{ $service->name }}@if (!$loop->last)
                                                            ,
                                                        @endif
                                                    @endforeach
                                                </p>
                                            </div>
                                            <div class="text-end">
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
                                                <span
                                                    class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }} mb-2">
                                                    {{ $statusTexts[$order->status] ?? $order->status }}
                                                </span>
                                                <h6 class="mb-0">{{ number_format($order->total_price) }} ج.م</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <a href="{{ route('client.order.showMyOrder', $order->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-2">لا توجد طلبات حتى الآن</p>
                            <a href="{{ route('carWash.availableCarWashes') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle"></i> إنشاء طلب جديد
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- خدمات مقترحة (اختياري - ممكن تجيبها من DB) -->
    @if (isset($suggestedCarwashes) && $suggestedCarwashes->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <h5 class="mb-3">خدمات مقترحة لك</h5>
            </div>

            @foreach ($suggestedCarwashes as $carwash)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        @if ($carwash->image)
                            <img src="{{ $carwash->image }}" class="card-img-top" alt="{{ $carwash->name }}"
                                style="height: 150px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                style="height: 150px;">
                                <i class="bi bi-building fs-1 text-muted"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $carwash->name }}</h5>
                            <p class="card-text small text-muted">
                                <i class="bi bi-star-fill text-warning"></i> {{ $carwash->rating ?? '4.5' }}
                                ({{ $carwash->reviews_count ?? 0 }} تقييم)
                            </p>
                            <p class="card-text">{{ $carwash->description ?? 'خدمة غسيل كامل + تعقيم داخلي' }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">{{ $carwash->starting_price ?? '120' }} ج.م</h6>
                                <a href="{{ route('client.orders.create', $carwash->id) }}"
                                    class="btn btn-sm btn-primary">احجز الآن</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
