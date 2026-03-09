@extends('layouts.dashboard')

@section('title', 'المغاسل المتاحة')
@section('page-title', 'المغاسل المتاحة')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">المغاسل المتاحة</h2>
            </div>
        </div>

        @if ($carWashes->isEmpty())
            <div class="alert alert-info">
                لا توجد مغاسل متاحة حالياً
            </div>
        @else
            <div class="row">
                @foreach ($carWashes as $carWash)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title mb-0">{{ $carWash->name }}</h5>
                                    <span class="badge bg-{{ $carWash->is_active ? 'success' : 'danger' }}">
                                        {{ $carWash->is_active ? 'مفتوح' : 'مغلق' }}
                                    </span>
                                </div>

                                <h6 class="fw-bold mt-3 mb-2">الخدمات:</h6>

                                @if ($carWash->services->isEmpty())
                                    <p class="text-muted">لا توجد خدمات</p>
                                @else
                                    @foreach ($carWash->services as $service)
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>{{ $service->name }}</span>
                                            <span class="fw-bold">{{ $service->price }} ج.م</span>
                                        </div>
                                    @endforeach
                                @endif

                                @if ($carWash->is_active && $carWash->services->isNotEmpty())
                                    <a href="{{ route('client.orders.create', $carWash->id) }}"
                                        class="btn btn-primary w-100 mt-3">
                                        طلب خدمة
                                    </a>
                                @else
                                    <button class="btn btn-secondary w-100 mt-3" disabled>
                                        غير متاح
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
