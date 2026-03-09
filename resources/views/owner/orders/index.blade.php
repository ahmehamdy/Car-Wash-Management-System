@extends('layouts.dashboard')

@section('title', 'إدارة الطلبات')
@section('page-title', 'إدارة الطلبات')

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">
                        <i class="bi bi-receipt"></i>
                        @if (isset($statusText[$status]))
                            {{ $statusText[$status] }}
                        @else
                            إدارة الطلبات
                        @endif
                    </h5>
                    <p class="mb-0 small mt-1">
                        <i class="bi bi-building"></i> {{ $carWash->name }}
                    </p>
                </div>
                <div>
                    <a href="{{ route('carWash.orders.selectStatus', $carWash) }}" class="btn btn-light btn-sm">
                        <i class="bi bi-filter"></i> تغيير الحالة
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <span class="badge bg-primary fs-6 px-3 py-2">
                                {{ $orders->total() }} طلب
                            </span>
                        </div>
                        <div>
                            @if ($status && $status != 'all')
                                <span class="badge bg-{{ $statusColors[$status] ?? 'secondary' }}">
                                    {{ $statusText[$status] ?? $status }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <form
                        action="{{ route('carWash.orders.index', ['carWash' => $carWash->id, 'status' => $status ?? 'all']) }}"
                        method="GET" class="d-flex">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="ابحث برقم الطلب أو اسم العميل..." value="{{ request('search') }}">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                            @if (request()->has('search'))
                                <a href="{{ route('carWash.orders.index', ['carWash' => $carWash->id, 'status' => $status ?? 'all']) }}"
                                    class="btn btn-outline-danger">
                                    <i class="bi bi-x"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            @if ($orders->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-receipt display-1 text-muted"></i>
                    <h4 class="mt-3">لا توجد طلبات</h4>
                    <p class="text-muted">
                        @if ($status == 'pending')
                            لا توجد طلبات قيد الانتظار حالياً
                        @elseif($status == 'today')
                            لا توجد طلبات مجدولة لليوم
                        @else
                            لا توجد طلبات في هذه الحالة
                        @endif
                    </p>
                    <a href="{{ route('carWash.orders.selectStatus', $carWash) }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left"></i> عرض حالات أخرى
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th width="80">#</th>
                                <th>العميل</th>
                                <th>الخدمات</th>
                                <th>الموعد</th>
                                <th>المبلغ</th>
                                <th>الحالة</th>
                                <th width="150">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>
                                        <strong>#{{ $order->id }}</strong>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar me-2">
                                                <img src="https://ui-avatars.com/api/?name={{ $order->user->name ?? 'عميل' }}&background=random"
                                                    alt="صورة العميل" class="rounded-circle" width="40" height="40">
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $order->user->name ?? 'عميل' }}</div>
                                                <small class="text-muted">
                                                    {{ $order->vehicle_type ?? 'غير محدد' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @foreach ($order->services as $service)
                                            <span class="badge bg-light text-dark mb-1">
                                                {{ $service->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div>
                                            {{ $order->created_at->format('Y/m/d') }}
                                        </div>
                                        <small class="text-muted">
                                            {{ $order->created_at->format('h:i A') }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-primary">
                                            {{ number_format($order->total_price) }} ج.م
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }} px-3 py-2">
                                            {{ $statusText[$order->status] ?? $order->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-info"
                                                data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">
                                                <i class="bi bi-eye"></i>
                                            </button>

                                            @if (!empty($allowedTransitions[$order->status]))
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown">
                                                        <i class="bi bi-arrow-repeat"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @foreach ($allowedTransitions[$order->status] as $newStatus)
                                                            <li>
                                                                <form
                                                                    action="{{ route('carWash.orders.updateStatus', $order) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status"
                                                                        value="{{ $newStatus }}">
                                                                    <button type="submit" class="dropdown-item"
                                                                        onclick="return confirmChangeStatus('{{ $statusText[$order->status] }}', '{{ $statusText[$newStatus] }}')">
                                                                        <i class="bi bi-arrow-right"></i>
                                                                        تغيير إلى {{ $statusText[$newStatus] }}
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @else
                                                <button class="btn btn-sm btn-outline-secondary" disabled>
                                                    <i class="bi bi-lock"></i>
                                                </button>
                                            @endif
                                        </div>

                                        <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal"></button>
                                                        <h5 class="modal-title">تفاصيل الطلب #{{ $order->id }}</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <h6>معلومات العميل</h6>
                                                                <table class="table table-sm">
                                                                    <tr>
                                                                        <td>الاسم:</td>
                                                                        <td>{{ $order->user->name ?? 'غير محدد' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>الهاتف:</td>
                                                                        <td>{{ $order->user->phone ?? 'غير محدد' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>البريد:</td>
                                                                        <td>{{ $order->user->email ?? 'غير محدد' }}</td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h6>معلومات المركبة</h6>
                                                                <table class="table table-sm">
                                                                    <tr>
                                                                        <td>النوع:</td>
                                                                        <td>{{ $order->vehicle_type ?? 'غير محدد' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>الرقم:</td>
                                                                        <td>{{ $order->vehicle_number ?? 'غير محدد' }}</td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <hr>

                                                        <h6>الخدمات المطلوبة</h6>
                                                        <div class="table-responsive">
                                                            <table class="table table-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th>الخدمة</th>
                                                                        <th>السعر</th>
                                                                        <th>المدة</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($order->services as $service)
                                                                        <tr>
                                                                            <td>{{ $service->name }}</td>
                                                                            <td>{{ number_format($service->price) }} ج.م
                                                                            </td>
                                                                            <td>{{ $service->duration }} دقيقة</td>
                                                                        </tr>
                                                                    @endforeach
                                                                    <tr class="table-primary">
                                                                        <td colspan="2" class="text-end fw-bold">
                                                                            الإجمالي:</td>
                                                                        <td class="fw-bold">
                                                                            {{ number_format($order->total_price) }} ج.م
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        @if ($order->notes)
                                                            <div class="mt-3">
                                                                <h6>ملاحظات إضافية</h6>
                                                                <div class="alert alert-light">
                                                                    {{ $order->notes }}
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">إغلاق</button>
                                                        <a href="tel:{{ $order->user->phone ?? '' }}"
                                                            class="btn btn-primary">
                                                            <i class="bi bi-telephone"></i> الاتصال بالعميل
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($orders->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            عرض {{ $orders->firstItem() }} إلى {{ $orders->lastItem() }} من أصل {{ $orders->total() }}
                        </div>
                        <div>
                            {{ $orders->links() }}
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <style>
        .status-badge {
            min-width: 100px;
            text-align: center;
        }

        .btn-group .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .dropdown-menu {
            min-width: 200px;
        }

        .dropdown-item {
            text-align: right;
            padding: 0.5rem 1rem;
        }

        .dropdown-item i {
            margin-left: 0.5rem;
        }
    </style>

    <script>
        function confirmChangeStatus(currentStatus, newStatus) {
            return confirm(`هل أنت متأكد من تغيير حالة الطلب من "${currentStatus}" إلى "${newStatus}"؟`);
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('form[action*="updateStatus"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const form = this;
                    const button = form.querySelector('button[type="submit"]');
                    const originalText = button.innerHTML;

                    button.innerHTML = '<i class="bi bi-hourglass"></i>';
                    button.disabled = true;

                    fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: new URLSearchParams(new FormData(form))
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                alert(data.message || 'حدث خطأ أثناء تحديث الحالة');
                                button.innerHTML = originalText;
                                button.disabled = false;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('حدث خطأ في الاتصال بالخادم');
                            button.innerHTML = originalText;
                            button.disabled = false;
                        });
                });
            });
        });
    </script>
@endsection
