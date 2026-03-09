@extends('layouts.dashboard')

@section('title', $carWash->name)
@section('page-title', $carWash->name)

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    @if ($errors->any())
                        <div>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-5">
                            <div id="carWashCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner rounded">

                                    @if (!empty($carWash->images))
                                        @foreach ($carWash->images as $index => $image)
                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                <img src="{{ Storage::url($image) }}" class="d-block w-100 carwash-show-img"
                                                    alt="{{ $carWash->name }}">
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="carousel-item active">
                                            <div class="no-image bg-light d-flex align-items-center justify-content-center"
                                                style="height: 300px;">
                                                <i class="bi bi-building display-1 text-muted"></i>
                                            </div>
                                        </div>
                                    @endif

                                </div>

                                @if (count($carWash->images ?? []) > 1)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carWashCarousel"
                                        data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>

                                    <button class="carousel-control-next" type="button" data-bs-target="#carWashCarousel"
                                        data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                @endif
                            </div>

                            @if (!empty($carWash->images))
                                <div class="mt-2 text-center">
                                    <small class="text-muted">
                                        <i class="bi bi-images"></i> {{ count($carWash->images) }} صورة
                                    </small>
                                </div>
                            @endif
                        </div>


                        <div class="col-md-7">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h4 class="mb-1">{{ $carWash->name }}</h4>
                                    <span class="badge bg-{{ $carWash->is_active ? 'success' : 'secondary' }} mb-2">
                                        {{ $carWash->is_active ? 'نشطة' : 'غير نشطة' }}
                                    </span>
                                </div>
                                <div class="btn-group">
                                    <a href="{{ route('carWash.edit', $carWash) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="carwash-details mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-geo-alt text-primary me-2"></i>
                                    <span>{{ $carWash->address }}</span>
                                </div>

                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-telephone text-primary me-2"></i>
                                    <a href="tel:{{ $carWash->phone }}" class="text-decoration-none">
                                        {{ $carWash->phone }}
                                    </a>
                                </div>

                                @if ($carWash->description)
                                    <div class="mt-3">
                                        <h6>الوصف</h6>
                                        <p class="text-muted">{{ $carWash->description }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="carwash-stats">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <div class="display-6 fw-bold text-primary">
                                            {{ $carWash->services()->count() ?? 0 }}
                                        </div>
                                        <small class="text-muted">الخدمات</small>
                                    </div>
                                    <div class="col-4">
                                        <div class="display-6 fw-bold text-success">{{ $carWash->orders()->count() ?? 0 }}
                                        </div>
                                        <small class="text-muted">الطلبات</small>
                                    </div>
                                    <div class="col-4">
                                        <div class="display-6 fw-bold text-warning">4.5</div>
                                        <small class="text-muted">التقييم</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">إحصائيات الطلبات</h6>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <div class="list-group-item border-0 d-flex justify-content-between">
                                    <span>قيد الانتظار</span>
                                    <span class="badge bg-warning">{{ $pendingOrders ?? 0 }}</span>
                                </div>
                                <div class="list-group-item border-0 d-flex justify-content-between">
                                    <span>قيد التنفيذ</span>
                                    <span class="badge bg-primary">{{ $inProgressOrders ?? 0 }}</span>
                                </div>
                                <div class="list-group-item border-0 d-flex justify-content-between">
                                    <span>مكتملة</span>
                                    <span class="badge bg-success">{{ $completedOrders ?? 0 }}</span>
                                </div>
                                <div class="list-group-item border-0 d-flex justify-content-between">
                                    <span>ملغية</span>
                                    <span class="badge bg-danger">{{ $cancelledOrders ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">الإيرادات</h6>
                        </div>
                        <div class="card-body">
                            <div class="text-center py-3">
                                <div class="display-4 fw-bold text-success">
                                    {{ number_format($totalRevenue ?? 0) }} ج.م
                                </div>
                                <small class="text-muted">إجمالي الإيرادات</small>
                            </div>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-success" style="width: 75%"></div>
                            </div>
                            <small class="text-muted d-block mt-2">75% من الهدف الشهري</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">الخدمات المتاحة</h6>
                    <a href="{{ route('services.index', $carWash) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus"></i> إدارة الخدمات
                    </a>
                </div>
                <div class="card-body">
                    @if ($carWash->services->isEmpty())
                        <div class="text-center py-3">
                            <i class="bi bi-bucket display-4 text-muted"></i>
                            <p class="text-muted mt-2">لا توجد خدمات</p>
                            <a href="{{ route('services.create', $carWash) }}" class="btn btn-primary">
                                <i class="bi bi-plus"></i> إضافة خدمة جديدة
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>الخدمة</th>
                                        <th>السعر</th>
                                        <th>المدة</th>
                                        <th>التصنيف</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carWash->services as $service)
                                        <tr>
                                            <td>{{ $service->name }}</td>
                                            <td>{{ number_format($service->price) }} ج.م</td>
                                            <td>{{ $service->duration }} دقيقة</td>
                                            <td>{{ $service->category }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">إجراءات سريعة</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('carWash.orders.selectStatus', $carWash) }}" class="btn btn-primary">
                            <i class="bi bi-receipt"></i> إدارة الطلبات
                        </a>
                        <a href="{{ route('services.index', $carWash) }}" class="btn btn-success">
                            <i class="bi bi-bucket"></i> إدارة الخدمات
                        </a>
                        <a href="{{ route('car-wash-working-hours.index', $carWash) }}" class="btn btn-info">
                            <i class="bi bi-clock"></i> مواعيد العمل
                        </a>
                        <a href="{{ route('carwashes.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-right"></i> العودة للمغاسل
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">معلومات إضافية</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 d-flex justify-content-between">
                            <span>تاريخ الإنشاء</span>
                            <span>{{ $carWash->created_at->format('Y/m/d') }}</span>
                        </div>
                        <div class="list-group-item border-0 d-flex justify-content-between">
                            <span>آخر تحديث</span>
                            <span>{{ $carWash->updated_at->format('Y/m/d') }}</span>
                        </div>
                        <div class="list-group-item border-0 d-flex justify-content-between">
                            <span>متوسط وقت الخدمة</span>
                            <span>45 دقيقة</span>
                        </div>
                        <div class="list-group-item border-0 d-flex justify-content-between">
                            <span>معدل الإلغاء</span>
                            <span class="text-danger">5%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">آخر الطلبات</h6>
                </div>
                <div class="card-body">
                    @if ($recentOrders && $recentOrders->isNotEmpty())
                        <div class="list-group list-group-flush">
                            @foreach ($recentOrders as $order)
                                <a href="#" class="list-group-item list-group-item-action border-0">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <div class="fw-semibold">#{{ $order->id }}</div>
                                            <small class="text-muted">{{ $order->user->name ?? 'عميل' }}</small>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                                {{ $statusText[$order->status] ?? $order->status }}
                                            </span>
                                            <div class="text-primary fw-bold mt-1">
                                                {{ number_format($order->total_price) }} ج.م
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('carWash.orders.selectStatus', $carWash) }}"
                                class="btn btn-sm btn-outline-primary">
                                عرض جميع الطلبات
                            </a>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="bi bi-receipt display-4 text-muted"></i>
                            <p class="text-muted mt-2">لا توجد طلبات حديثة</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .carwash-show-img {
            height: 300px;
            object-fit: cover;
        }

        .no-image {
            height: 300px;
            border-radius: 8px;
        }

        .carwash-details i {
            width: 20px;
        }

        .carwash-stats .display-6 {
            font-size: 2.5rem;
        }

        .list-group-item {
            padding: 0.75rem 0;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }
    </style>

    <script>
        const carousel = new bootstrap.Carousel(document.getElementById('carWashCarousel'), {
            interval: 3000,
            wrap: true
        });
    </script>
@endsection
