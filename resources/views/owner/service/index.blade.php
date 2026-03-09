@extends('layouts.dashboard')

@section('title', 'إدارة الخدمات')
@section('page-title', 'إدارة الخدمات - ' . $carWash->name)

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">
                        <i class="bi bi-bucket"></i> خدمات مغسلة: {{ $carWash->name }}
                    </h5>
                    <p class="mb-0 small mt-1">إدارة جميع خدمات المغسلة</p>
                </div>
                <div>
                    <a href="{{ route('services.create', $carWash) }}" class="btn btn-light">
                        <i class="bi bi-plus-lg"></i> إضافة خدمة جديدة
                    </a>
                    <a href="{{ route('carwashes.index') }}" class="btn btn-outline-light ms-2">
                        <i class="bi bi-arrow-right"></i> المغاسل
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

            @if ($services->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-bucket display-1 text-muted"></i>
                    <h4 class="mt-3">لا توجد خدمات</h4>
                    <p class="text-muted">ابدأ بإضافة خدمات للمغسلة</p>
                    <a href="{{ route('services.create', $carWash) }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> إضافة خدمة جديدة
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th width="60">#</th>
                                <th>اسم الخدمة</th>
                                <th>السعر</th>
                                <th>عدد الطلبات</th>
                                <th>تاريخ الإضافة</th>
                                <th width="150">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $service)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="service-icon me-3">
                                                <div class="rounded-circle bg-primary bg-opacity-10 p-2">
                                                    <i class="bi bi-droplet text-primary"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $service->name }}</h6>
                                                @if ($service->description)
                                                    <small
                                                        class="text-muted">{{ Str::limit($service->description, 50) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success">
                                            {{ number_format($service->price) }} ج.م
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $service->orders_count ?? 0 }} طلب
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $service->created_at->format('Y/m/d') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('services.edit', ['carWash' => $carWash, 'service' => $service]) }}"
                                                class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $service->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>

                                        <div class="modal fade" id="deleteModal{{ $service->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">تأكيد الحذف</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>هل أنت متأكد من حذف خدمة
                                                            <strong>"{{ $service->name }}"</strong>؟</p>
                                                        <div class="alert alert-warning">
                                                            <i class="bi bi-exclamation-triangle"></i>
                                                            <small>إذا كانت هذه الخدمة مرتبطة بطلبات حالية، فقد تؤثر على تلك
                                                                الطلبات.</small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">إلغاء</button>
                                                        <form action="{{ route('services.destroy', $service) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">حذف</button>
                                                        </form>
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

                <div class="row mt-4">
                    <div class="col-md-3 col-6">
                        <div class="card border-start border-primary border-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted mb-1">عدد الخدمات</h6>
                                        <h4 class="mb-0">{{ $services->count() }}</h4>
                                    </div>
                                    <i class="bi bi-list-check text-primary fs-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-6">
                        <div class="card border-start border-success border-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted mb-1">متوسط السعر</h6>
                                        <h4 class="mb-0">{{ number_format($services->avg('price') ?? 0) }} ج.م</h4>
                                    </div>
                                    <i class="bi bi-currency-dollar text-success fs-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-6">
                        <div class="card border-start border-warning border-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted mb-1">أعلى سعر</h6>
                                        <h4 class="mb-0">{{ number_format($services->max('price') ?? 0) }} ج.م</h4>
                                    </div>
                                    <i class="bi bi-arrow-up text-warning fs-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-6">
                        <div class="card border-start border-info border-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted mb-1">أقل سعر</h6>
                                        <h4 class="mb-0">{{ number_format($services->min('price') ?? 0) }} ج.م</h4>
                                    </div>
                                    <i class="bi bi-arrow-down text-info fs-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="card-footer bg-light">
            <div class="d-flex justify-content-between">
                <div>
                    <a href="{{ route('carWash.show', $carWash) }}" class="btn btn-outline-primary">
                        <i class="bi bi-eye"></i> عرض تفاصيل المغسلة
                    </a>
                    <a href="{{ route('car-wash-working-hours.index', $carWash) }}" class="btn btn-outline-info ms-2">
                        <i class="bi bi-clock"></i> مواعيد العمل
                    </a>
                </div>
                <div>
                    <a href="{{ route('services.create', $carWash) }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> إضافة خدمة جديدة
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .service-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .table td {
            vertical-align: middle;
        }
    </style>
@endsection
