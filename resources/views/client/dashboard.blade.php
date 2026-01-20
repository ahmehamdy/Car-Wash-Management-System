@extends('layouts.dashboard')

@section('title', 'لوحة التحكم - العميل')
@section('page-title', 'لوحة التحكم')

@section('content')
    <div class="row">
        <!-- Welcome Card -->
        <div class="col-12 mb-4">
            <div class="stat-card bg-primary text-white">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="mb-3">مرحباً بعودتك، {{ auth()->user()->name }}! 👋</h4>
                        <p class="mb-0">لديك 3 طلبات نشطة حالياً. آخر طلب لك كان أمس.</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="{{ route('carwashes.index') }}" class="btn btn-light btn-lg">
                            <i class="bi bi-plus-circle"></i> احجز خدمة جديدة
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">الطلبات النشطة</h6>
                        <h3 class="mb-0">3</h3>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-clock-history"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('client.orders.index', ['status' => 'confirmed']) }}" class="text-decoration-none">
                        عرض الطلبات <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">طلبات مكتملة</h6>
                        <h3 class="mb-0">27</h3>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('client.orders.index', ['status' => 'completed']) }}" class="text-decoration-none">
                        عرض الطلبات <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">المغاسل المفضلة</h6>
                        <h3 class="mb-0">5</h3>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-heart"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="#" class="text-decoration-none">
                        عرض المفضلة <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">الرصيد</h6>
                        <h3 class="mb-0">350 ر.س</h3>
                    </div>
                    <div class="stat-icon bg-info bg-opacity-10 text-info">
                        <i class="bi bi-wallet2"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="#" class="text-decoration-none">
                        شحن الرصيد <i class="bi bi-plus-circle"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Active Orders -->
        <div class="col-xl-8 mb-4">
            <div class="table-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">طلباتي النشطة</h5>
                    <a href="#" class="btn btn-outline-primary btn-sm">عرض كل الطلبات</a>
                </div>

                {{-- @if (count($activeOrders) > 0)
                    @foreach ($activeOrders as $order)
                        <div class="card border mb-3">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $order->carwash->images[0] ?? 'https://images.unsplash.com/photo-1565689221354-d87f85d4aee2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}"
                                                alt="Car Wash" class="rounded me-3" width="80" height="80">
                                            <div>
                                                <h6 class="mb-1">{{ $order->carwash->name }}</h6>
                                                <small class="text-muted">{{ $order->carwash->location }}</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div>
                                            <small class="text-muted d-block">الخدمات</small>
                                            @foreach ($order->services as $service)
                                                <span class="badge bg-light text-dark me-1">{{ $service->name }}</span>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div>
                                            <small class="text-muted d-block">المبلغ الإجمالي</small>
                                            <h6 class="mb-0">{{ number_format($order->total_price) }} ر.س</h6>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="text-md-end">
                                            <span class="badge badge-{{ $order->status }} mb-2">
                                                {{ $order->status_text }}
                                            </span>
                                            <br>
                                            <a href="{{ route('orders.show', $order->id) }}"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-eye"></i> التفاصيل
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Progress -->
                                <div class="mt-4">
                                    <div class="order-progress">
                                        @php
                                            $steps = ['pending', 'accepted', 'in-progress', 'completed'];
                                            $currentStep = array_search($order->status, $steps);
                                        @endphp

                                        @foreach ($steps as $index => $step)
                                            <div class="text-center">
                                                <div
                                                    class="progress-step {{ $index <= $currentStep ? 'completed' : '' }} {{ $index == $currentStep ? 'active' : '' }}">
                                                    {{ $index + 1 }}
                                                </div>
                                                <small class="d-block mt-1">
                                                    @if ($step == 'pending')
                                                        في الانتظار
                                                    @elseif($step == 'accepted')
                                                        مقبول
                                                    @elseif($step == 'in-progress')
                                                        قيد التنفيذ
                                                    @elseif($step == 'completed')
                                                        مكتمل
                                                    @endif
                                                </small>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="bi bi-clock"></i>
                        <h5 class="mt-3">لا توجد طلبات نشطة حالياً</h5>
                        <p class="text-muted">يمكنك حجز خدمة جديدة الآن</p>
                        <a href="{{ route('carwashes.index') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> احجز خدمة جديدة
                        </a>
                    </div>
                @endif --}}
            </div>
        </div>

        <!-- Quick Actions & Stats -->
        <div class="col-xl-4 mb-4">
            <!-- Quick Actions -->
            <div class="table-card mb-4">
                <h5 class="mb-4">إجراءات سريعة</h5>
                <div class="row g-3">
                    <div class="col-6">
                        <a href="{{ route('carwashes.index') }}" class="btn btn-outline-primary w-100 h-100 py-3">
                            <i class="bi bi-search display-6 d-block mb-2"></i>
                            <span>ابحث عن مغسلة</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="#" class="btn btn-outline-success w-100 h-100 py-3">
                            <i class="bi bi-plus-circle display-6 d-block mb-2"></i>
                            <span>حجز جديد</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="#" class="btn btn-outline-warning w-100 h-100 py-3">
                            <i class="bi bi-heart display-6 d-block mb-2"></i>
                            <span>المفضلة</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="#" class="btn btn-outline-info w-100 h-100 py-3">
                            <i class="bi bi-wallet2 display-6 d-block mb-2"></i>
                            <span>رصيدي</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Car Washes -->
            <div class="table-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">آخر المغاسل التي زُرتها</h5>
                    <a href="{{ route('carwashes.index') }}" class="btn btn-link btn-sm">المزيد</a>
                </div>

                <div class="list-group">
                    @for ($i = 1; $i <= 3; $i++)
                        <a href="#" class="list-group-item list-group-item-action border-0">
                            <div class="d-flex align-items-center">
                                <img src="https://images.unsplash.com/photo-1565689221354-d87f85d4aee2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                    alt="Car Wash" class="rounded me-3" width="50" height="50">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">مغسلة النخبة {{ $i }}</h6>
                                    <small class="text-muted">
                                        <i class="bi bi-star-fill text-warning"></i> 4.5 | الرياض
                                    </small>
                                </div>
                                <div>
                                    <span class="badge bg-success">مفتوح</span>
                                </div>
                            </div>
                        </a>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Orders -->
        <div class="col-12">
            <div class="table-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">آخر الطلبات</h5>
                    <a href="#" class="btn btn-outline-primary btn-sm">عرض كل الطلبات</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>رقم الطلب</th>
                                <th>المغسلة</th>
                                <th>التاريخ</th>
                                <th>الخدمات</th>
                                <th>المبلغ</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 1; $i <= 5; $i++)
                                <tr>
                                    <td>#CW{{ 2000 + $i }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=مغسلة+{{ $i }}&background=random"
                                                alt="Car Wash" class="rounded-circle me-2" width="30"
                                                height="30">
                                            <span>مغسلة النخبة {{ $i }}</span>
                                        </div>
                                    </td>
                                    <td>{{ now()->subDays($i)->format('Y/m/d') }}</td>
                                    <td>
                                        <span class="service-tag">غسيل خارجي</span>
                                        @if ($i % 2 == 0)
                                            <span class="service-tag">تلميع</span>
                                        @endif
                                    </td>
                                    <td>{{ 100 + $i * 20 }} ر.س</td>
                                    <td>
                                        @php
                                            $statuses = ['completed', 'completed', 'completed', 'cancelled', 'pending'];
                                            $status = $statuses[$i - 1];
                                            $statusClasses = [
                                                'pending' => 'warning',
                                                'completed' => 'success',
                                                'cancelled' => 'danger',
                                            ];
                                            $statusText = [
                                                'pending' => 'قيد الانتظار',
                                                'completed' => 'مكتمل',
                                                'cancelled' => 'ملغى',
                                            ];
                                        @endphp
                                        <span
                                            class="badge bg-{{ $statusClasses[$status] }}">{{ $statusText[$status] }}</span>
                                    </td>
                                    <td>
                                        <button class="btn-action btn btn-outline-primary" title="عرض التفاصيل">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        @if ($status == 'completed')
                                            <button class="btn-action btn btn-outline-warning" title="تقييم الخدمة">
                                                <i class="bi bi-star"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Simulate active orders data
        const activeOrders = [{
                id: 1,
                carwash: {
                    name: "مغسلة النخبة",
                    location: "الرياض، حي العليا"
                },
                services: [{
                    name: "غسيل خارجي كامل"
                }, {
                    name: "تلميع"
                }],
                total_price: 250,
                status: "in-progress",
                status_text: "قيد التنفيذ"
            },
            {
                id: 2,
                carwash: {
                    name: "مغسلة اللمعة",
                    location: "الرياض، حي الملز"
                },
                services: [{
                    name: "غسيل داخلي"
                }],
                total_price: 120,
                status: "accepted",
                status_text: "مقبول"
            }
        ];

        // Update order status display
        document.querySelectorAll('.order-status').forEach(status => {
            const statusValue = status.dataset.status;
            const statusMap = {
                'pending': {
                    class: 'warning',
                    text: 'قيد الانتظار'
                },
                'confirmed': {
                    class: 'info',
                    text: 'مقبول'
                },
                'completed': {
                    class: 'success',
                    text: 'مكتمل'
                },
                'cancelled': {
                    class: 'danger',
                    text: 'ملغى'
                }
            };

            if (statusMap[statusValue]) {
                status.className = `badge bg-${statusMap[statusValue].class}`;
                status.textContent = statusMap[statusValue].text;
            }
        });
    </script>
@endpush
