@extends('layouts.dashboard')

@section('title', 'تعديل الطلب')
@section('page-title', 'تعديل الطلب #ORD-2024-001')

@section('content')
    <div class="alert alert-warning mb-4">
        <i class="bi bi-exclamation-triangle"></i>
        يمكنك تعديل الطلب قبل بدء التنفيذ فقط. بمجرد بدء التنفيذ، لا يمكن إجراء تعديلات.
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">تعديل معلومات الطلب</h5>
                    <span class="badge bg-warning">قيد الانتظار</span>
                </div>
                <div class="card-body">
                    <form action="#" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- اختيار المغسلة (معطل) -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">المغسلة</label>
                            <input type="text" class="form-control" value="مغسلة النور للسيارات" readonly disabled>
                        </div>

                        <!-- اختيار الخدمات -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">الخدمات</label>

                            @php
                                $services = [
                                    ['id' => 1, 'name' => 'غسيل خارجي', 'price' => 50, 'checked' => true],
                                    ['id' => 2, 'name' => 'غسيل داخلي', 'price' => 80, 'checked' => true],
                                    ['id' => 3, 'name' => 'تلميع سيراميك', 'price' => 200, 'checked' => false],
                                    ['id' => 4, 'name' => 'تعقيم داخلي', 'price' => 60, 'checked' => false],
                                    ['id' => 5, 'name' => 'تنظيف مكيف', 'price' => 40, 'checked' => true],
                                ];
                            @endphp

                            @foreach ($services as $service)
                                <div class="form-check mb-2 p-3 border rounded">
                                    <input class="form-check-input" type="checkbox" name="services[]"
                                        value="{{ $service['id'] }}" id="service{{ $service['id'] }}"
                                        data-price="{{ $service['price'] }}" {{ $service['checked'] ? 'checked' : '' }}
                                        onchange="updateTotal()">
                                    <label class="form-check-label w-100" for="service{{ $service['id'] }}">
                                        <div class="d-flex justify-content-between">
                                            <span>{{ $service['name'] }}</span>
                                            <span class="text-primary">{{ $service['price'] }} ر.س</span>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <!-- معلومات السيارة -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">الماركة</label>
                                <input type="text" class="form-control" value="تويوتا" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">الموديل</label>
                                <input type="text" class="form-control" value="كامري 2023" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold mt-3">رقم اللوحة</label>
                                <input type="text" class="form-control" value="أ ب ج 1234" required>
                            </div>
                        </div>

                        <!-- موعد التنفيذ -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">تاريخ التنفيذ</label>
                                <input type="date" class="form-control" value="2024-02-16" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">وقت التنفيذ</label>
                                <input type="time" class="form-control" value="14:00" required>
                            </div>
                        </div>

                        <!-- ملاحظات -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">ملاحظات إضافية</label>
                            <textarea class="form-control" rows="3">يفضل التواصل قبل القدوم</textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> حفظ التعديلات
                            </button>
                            <a href="{{ route('orders.show', 1) }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> إلغاء
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
                    <div id="selectedServices">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>غسيل خارجي</span>
                            <span class="text-primary">50 ر.س</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>غسيل داخلي</span>
                            <span class="text-primary">80 ر.س</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>تنظيف مكيف</span>
                            <span class="text-primary">40 ر.س</span>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span>المجموع:</span>
                        <span class="fw-bold" id="subtotal">170 ر.س</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>الضريبة (15%):</span>
                        <span class="fw-bold" id="tax">25.5 ر.س</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="h5">الإجمالي:</span>
                        <span class="h5 text-primary" id="total">195.5 ر.س</span>
                    </div>

                    <hr>

                    <!-- تاريخ التعديلات -->
                    <div class="small text-muted">
                        <p class="mb-1"><i class="bi bi-clock-history"></i> آخر تعديل: 15 فبراير 2024 - 11:30 صباحاً</p>
                        <p class="mb-0"><i class="bi bi-person"></i> تم الإنشاء: 15 فبراير 2024 - 10:30 صباحاً</p>
                    </div>
                </div>
            </div>

            <!-- زر الإلغاء -->
            <div class="card border-danger">
                <div class="card-body">
                    <h6 class="text-danger"><i class="bi bi-exclamation-triangle"></i> منطقة خطر</h6>
                    <p class="small">إذا أردت إلغاء الطلب بالكامل</p>
                    <button class="btn btn-outline-danger w-100" onclick="confirmCancel()">
                        <i class="bi bi-x-circle"></i> إلغاء الطلب
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal تأكيد الإلغاء -->
    <div class="modal fade" id="cancelModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تأكيد إلغاء الطلب</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>هل أنت متأكد من رغبتك في إلغاء هذا الطلب؟</p>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        لا يمكن التراجع عن هذا الإجراء بعد التأكيد.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">تراجع</button>
                    <button type="button" class="btn btn-danger">تأكيد الإلغاء</button>
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

            document.querySelectorAll('input[name="services[]"]:checked').forEach(checkbox => {
                const price = parseFloat(checkbox.dataset.price);
                subtotal += price;

                const label = checkbox.nextElementSibling;
                const serviceName = label.querySelector('.d-flex span:first-child').textContent;

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
        }

        function confirmCancel() {
            var cancelModal = new bootstrap.Modal(document.getElementById('cancelModal'));
            cancelModal.show();
        }
    </script>
@endpush
