@extends('layouts.dashboard')

@section('title', $service->name)
@section('page-title', $service->name)

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-bucket"></i> {{ $service->name }}
                        </h5>
                        <div class="btn-group">
                            <a href="{{ route('services.edit', ['carWash' => $carWash, 'service' => $service]) }}"
                                class="btn btn-light btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="{{ route('services.index', $carWash) }}" class="btn btn-outline-light btn-sm ms-2">
                                <i class="bi bi-arrow-right"></i> الخدمات
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="service-details mb-4">
                                <h6>معلومات الخدمة</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <td width="120">السعر:</td>
                                        <td>
                                            <span class="fw-bold text-success fs-5">
                                                {{ number_format($service->price) }} ر.س
                                            </span>
                                        </td>
                                    </tr>
                                    @if ($service->duration)
                                        <tr>
                                            <td>مدة التنفيذ:</td>
                                            <td>{{ $service->duration }} دقيقة</td>
                                        </tr>
                                    @endif
                                    @if ($service->category)
                                        <tr>
                                            <td>التصنيف:</td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ $categoryNames[$service->category] ?? $service->category }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>الحالة:</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $service->status == 'active' ? 'success' : 'secondary' }}">
                                                {{ $service->status == 'active' ? 'نشطة' : 'غير نشطة' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>تاريخ الإضافة:</td>
                                        <td>{{ $service->created_at->format('Y/m/d') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="service-flags mb-4">
                                <h6>علامات الخدمة</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @if ($service->is_popular ?? false)
                                        <span class="badge bg-warning">
                                            <i class="bi bi-star"></i> خدمة شائعة
                                        </span>
                                    @endif

                                    @if ($service->available_for_online ?? true)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> متاحة أونلاين
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-x-circle"></i> غير متاحة أونلاين
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="service-stats">
                                <h6>إحصائيات</h6>
                                <div class="row text-center">
                                    <div class="col-6">
                                        <div class="fs-2 fw-bold text-primary">{{ $service->orders_count ?? 0 }}</div>
                                        <small class="text-muted">الطلبات</small>
                                    </div>
                                    <div class="col-6">
                                        <div class="fs-2 fw-bold text-success">
                                            {{ number_format($totalRevenue ?? 0) }} ر.س
                                        </div>
                                        <small class="text-muted">إجمالي الإيرادات</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($service->description)
                        <div class="mt-4">
                            <h6>وصف الخدمة</h6>
                            <div class="alert alert-light">
                                {{ $service->description }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">آخر الطلبات لهذه الخدمة</h6>
                    <a href="{{ route('carWash.orders.select', $carWash) }}" class="btn btn-sm btn-outline-primary">
                        عرض جميع الطلبات
                    </a>
                </div>
                <div class="card-body">
                    @if ($recentOrders && $recentOrders->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>رقم الطلب</th>
                                        <th>العميل</th>
                                        <th>التاريخ</th>
                                        <th>الحالة</th>
                                        <th>المبلغ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentOrders as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->user->name ?? 'عميل' }}</td>
                                            <td>{{ $order->created_at->format('Y/m/d') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                                    {{ $statusText[$order->status] ?? $order->status }}
                                                </span>
                                            </td>
                                            <td>{{ number_format($order->total_price) }} ر.س</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="bi bi-receipt display-4 text-muted"></i>
                            <p class="text-muted mt-2">لا توجد طلبات حديثة لهذه الخدمة</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">المغسلة</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <i class="bi bi-building fs-3 text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $carWash->name }}</h6>
                            <small class="text-muted">{{ $carWash->location }}</small>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="{{ route('carWash.show', $carWash) }}" class="btn btn-outline-primary">
                            <i class="bi bi-eye"></i> عرض تفاصيل المغسلة
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">إجراءات سريعة</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('services.edit', ['carWash' => $carWash, 'service' => $service]) }}"
                            class="btn btn-warning">
                            <i class="bi bi-pencil"></i> تعديل الخدمة
                        </a>
                        <a href="{{ route('services.index', $carWash) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-right"></i> جميع الخدمات
                        </a>
                        <a href="{{ route('services.create', $carWash) }}" class="btn btn-outline-primary">
                            <i class="bi bi-plus"></i> إضافة خدمة جديدة
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">معلومات تقنية</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 d-flex justify-content-between">
                            <span>رقم الخدمة:</span>
                            <span class="fw-bold">#{{ $service->id }}</span>
                        </div>
                        <div class="list-group-item border-0 d-flex justify-content-between">
                            <span>آخر تحديث:</span>
                            <span>{{ $service->updated_at->format('Y/m/d H:i') }}</span>
                        </div>
                        <div class="list-group-item border-0 d-flex justify-content-between">
                            <span>متوسط وقت التنفيذ:</span>
                            <span>{{ $service->duration ?? 30 }} دقيقة</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .service-details table td {
            padding: 0.5rem 0;
            border-top: none;
        }

        .service-flags .badge {
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
        }

        .service-stats .fs-2 {
            font-size: 2rem;
        }
    </style>
@endsection
