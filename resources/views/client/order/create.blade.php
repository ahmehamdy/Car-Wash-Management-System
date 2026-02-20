@extends('layouts.dashboard')

@section('title', 'طلب جديد')
@section('page-title', 'إنشاء طلب جديد - ' . ($carWash->name ?? ''))

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">معلومات الطلب - {{ $carWash->name ?? '' }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('client.order.store', $carWash->id) }}" method="POST">
                        @csrf

                        <!-- ID المغسلة مخفي -->
                        <input type="hidden" name="car_wash_id" value="{{ $carWash->id ?? '' }}">

                        <!-- معلومات المغسلة (للقراءة فقط) -->
                        <div class="mb-4 p-3 bg-light rounded">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-muted small">المغسلة</label>
                                    <p class="fw-bold mb-0">{{ $carWash->name ?? '' }}</p>
                                </div>
                                @if (isset($carWash->address))
                                    <div class="col-md-6">
                                        <label class="text-muted small">العنوان</label>
                                        <p class="mb-0">{{ $carWash->address }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- اختيار الخدمات -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">اختر الخدمات</label>

                            @forelse($carWash->services as $service)
                                <div class="form-check mb-2 p-3 border rounded">
                                    <input class="form-check-input service-checkbox" type="checkbox" name="services[]"
                                        value="{{ $service->id }}" id="service{{ $service->id }}"
                                        data-price="{{ $service->price }}" data-name="{{ $service->name }}"
                                        onchange="updateTotal()">
                                    <label class="form-check-label w-100" for="service{{ $service->id }}">
                                        <div class="d-flex justify-content-between">
                                            <span>{{ $service->name }}</span>
                                            <span class="text-primary">{{ number_format($service->price) }} ر.س</span>
                                        </div>
                                    </label>
                                </div>
                            @empty
                                <div class="alert alert-warning">
                                    لا توجد خدمات متاحة في هذه المغسلة
                                </div>
                            @endforelse
                        </div>

                        <!-- موعد التنفيذ -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">موعد التنفيذ <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="pickup_time"
                                    class="form-control @error('pickup_time') is-invalid @enderror"
                                    value="{{ old('pickup_time') }}" min="{{ now()->format('Y-m-d\TH:i') }}" required>
                                <small class="text-muted">اختر التاريخ والوقت المناسبين</small>
                                {{-- @error('pickup_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror --}}
                            </div>
                        </div>

                        <!-- ملاحظات -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">ملاحظات إضافية</label>
                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3"
                                placeholder="أي ملاحظات تريد إضافتها...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- أزرار الإجراء -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                                <i class="bi bi-check-circle"></i> تأكيد الطلب
                            </button>
                            <a href="{{ route('carwashes.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-right"></i> رجوع
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- ملخص الطلب -->
            <div class="card mb-4 sticky-top" style="top: 20px;">
                <div class="card-header bg-white">
                    <h5 class="mb-0">ملخص الطلب</h5>
                </div>
                <div class="card-body">
                    <!-- معلومات المغسلة -->
                    <div class="mb-3 pb-3 border-bottom">
                        <small class="text-muted d-block">المغسلة</small>
                        <h6 class="mb-0">{{ $carWash->name ?? '' }}</h6>
                    </div>

                    <!-- الخدمات المختارة -->
                    <div id="selectedServices" class="mb-3">
                        <p class="text-muted mb-0">لم يتم اختيار أي خدمات</p>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span>المجموع:</span>
                        <span class="fw-bold" id="subtotal">0 ر.س</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>الضريبة (15%):</span>
                        <span class="fw-bold" id="tax">0 ر.س</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="h5">الإجمالي:</span>
                        <span class="h5 text-primary" id="total">0 ر.س</span>
                    </div>

                    <!-- رسالة تأكيد اختيار خدمة -->
                    <div id="serviceAlert" class="alert alert-warning small d-none">
                        <i class="bi bi-exclamation-triangle"></i>
                        يجب اختيار خدمة واحدة على الأقل
                    </div>
                </div>
            </div>

            <!-- معلومات المساعدة -->
            <div class="card bg-light">
                <div class="card-body">
                    <h6><i class="bi bi-question-circle"></i> تحتاج مساعدة؟</h6>
                    <p class="small mb-2">تواصل مع فريق الدعم الفني</p>
                    <a href="#" class="btn btn-outline-primary btn-sm w-100">
                        <i class="bi bi-headset"></i> الدعم الفني
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function updateTotal() {
            let subtotal = 0;
            let selectedHtml = '';
            let selectedCount = 0;

            document.querySelectorAll('input[name="services[]"]:checked').forEach(checkbox => {
                const price = parseFloat(checkbox.dataset.price);
                const serviceName = checkbox.dataset.name;

                subtotal += price;
                selectedCount++;

                selectedHtml += `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>${serviceName}</span>
                    <span class="text-primary">${price} ر.س</span>
                </div>
            `;
            });

            const tax = subtotal * 0.15;
            const total = subtotal + tax;

            document.getElementById('selectedServices').innerHTML = selectedHtml ||
                '<p class="text-muted mb-0">لم يتم اختيار أي خدمات</p>';

            document.getElementById('subtotal').textContent = subtotal.toFixed(2) + ' ر.س';
            document.getElementById('tax').textContent = tax.toFixed(2) + ' ر.س';
            document.getElementById('total').textContent = total.toFixed(2) + ' ر.س';

            const submitBtn = document.getElementById('submitBtn');
            const serviceAlert = document.getElementById('serviceAlert');

            if (selectedCount > 0) {
                submitBtn.disabled = false;
                serviceAlert.classList.add('d-none');
            } else {
                submitBtn.disabled = true;
                serviceAlert.classList.remove('d-none');
            }
        }
    </script>
@endpush
