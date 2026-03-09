@extends('layouts.dashboard')

@section('title', 'مغاسلي')
@section('page-title', 'إدارة المغاسل')

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">
                        <i class="bi bi-building"></i> مغاسلي
                    </h5>
                    <p class="mb-0 small mt-1">إدارة جميع مغاسلك في مكان واحد</p>
                </div>
                <div>
                    <a href="{{ route('carWash.create') }}" class="btn btn-light">
                        <i class="bi bi-plus-lg"></i> إضافة مغسلة جديدة
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

            @if ($carWashes->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-building display-1 text-muted"></i>
                    <h4 class="mt-3">لا توجد مغاسل</h4>
                    <p class="text-muted">ابدأ بإضافة مغسلة جديدة لإدارة عملك</p>
                    <a href="{{ route('carWash.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> إضافة مغسلة جديدة
                    </a>
                </div>
            @else
                <div class="row g-4">
                    @foreach ($carWashes as $carWash)
                        <div class="col-xl-4 col-lg-6">
                            <div class="card carwash-card shadow-sm" style="cursor: pointer;"
                                onclick="window.location='{{ route('carWash.show', $carWash) }}'">
                                <div class="carwash-image-container">
                                    @if (!empty($carWash->images))
                                        <img src="{{ Storage::url($carWash->images[0]) }}" class="card-img-top carwash-img"
                                            alt="{{ $carWash->name }}">

                                        <div class="image-count">
                                            <i class="bi bi-images"></i> {{ count($carWash->images ?? []) }}
                                        </div>
                                    @else
                                        <div class="no-image bg-light d-flex align-items-center justify-content-center">
                                            <i class="bi bi-building display-4 text-muted"></i>
                                        </div>
                                    @endif

                                    <div class="carwash-status">
                                        <span class="badge bg-{{ $carWash->is_active ? 'success' : 'secondary' }}">
                                            {{ $carWash->is_active ? 'نشطة' : 'غير نشطة' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">{{ $carWash->name }}</h5>

                                    <div class="carwash-info mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-geo-alt text-muted me-2"></i>
                                            <span class="text-muted">{{ Str::limit($carWash->address, 40) }}</span>
                                        </div>

                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-telephone text-muted me-2"></i>
                                            <span class="text-muted">{{ $carWash->phone }}</span>
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-bucket text-muted me-2"></i>
                                            <span class="text-muted">
                                                {{ $carWash->services()->count() ?? 0 }} خدمة
                                            </span>
                                        </div>
                                    </div>

                                    <div class="carwash-stats d-flex justify-content-between mb-3">
                                        <div class="text-center">
                                            <div class="fw-bold text-primary">{{ $carWash->orders()->count() ?? 0 }}</div>
                                            <small class="text-muted">الطلبات</small>
                                        </div>
                                        <div class="text-center">
                                            <div class="fw-bold text-success">
                                                {{ number_format($carWash->total_revenue ?? 0) }} ج.م
                                            </div>
                                            <small class="text-muted">الإيرادات</small>
                                        </div>
                                        <div class="text-center">
                                            <div class="fw-bold text-warning">4.5</div>
                                            <small class="text-muted">التقييم</small>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('carWash.edit', $carWash) }}"
                                                class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $carWash->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>

                                        <a href="{{ route('carWash.orders.selectStatus', $carWash) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="bi bi-receipt"></i> الطلبات
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="deleteModal{{ $carWash->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">تأكيد الحذف</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>هل أنت متأكد من حذف مغسلة <strong>"{{ $carWash->name }}"</strong>؟</p>
                                            <div class="alert alert-warning">
                                                <i class="bi bi-exclamation-triangle"></i>
                                                <small>سيتم حذف جميع الخدمات والصور المرتبطة بهذه المغسلة.</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">إلغاء</button>
                                            <form action="{{ route('carWash.destroy', $carWash) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">حذف</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($carWashes->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $carWashes->links('pagination::bootstrap-5') }}
                    </div>
                @endif

            @endif
        </div>
    </div>

    <style>
        .carwash-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
        }

        .carwash-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
        }

        .carwash-image-container {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .carwash-img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .carwash-card:hover .carwash-img {
            transform: scale(1.05);
        }

        .no-image {
            height: 200px;
            width: 100%;
        }

        .image-count {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        .carwash-status {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .carwash-info {
            font-size: 0.9rem;
        }

        .carwash-stats {
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }
    </style>

    <script>
        document.querySelectorAll('[data-bs-target^="#deleteModal"]').forEach(button => {
            button.addEventListener('click', function() {
                const modalId = this.getAttribute('data-bs-target');
                const modal = new bootstrap.Modal(document.querySelector(modalId));
                modal.show();
            });
        });
    </script>
@endsection
