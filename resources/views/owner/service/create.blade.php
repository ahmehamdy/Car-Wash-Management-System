@extends('layouts.dashboard')

@section('title', 'إضافة خدمة جديدة')
@section('page-title', 'إضافة خدمة جديدة - ' . $carWash->name)

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-plus-lg"></i> إضافة خدمة جديدة
            </h5>
            <a href="{{ route('services.index', $carWash) }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-right"></i> العودة للخدمات
            </a>
        </div>
    </div>

    <div class="card-body">
        <!-- عرض رسائل الخطأ -->
        @if($errors->any())
            <div class="alert alert-danger">
                <h6>يوجد أخطاء في النموذج:</h6>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('services.store', $carWash) }}" method="POST" id="serviceForm">
            @csrf

            <div class="row">
                <!-- المعلومات الأساسية -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">معلومات الخدمة</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">اسم الخدمة <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}"
                                           placeholder="أدخل اسم الخدمة (مثال: غسيل خارجي كامل)"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">السعر ( جنية مصرى) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number"
                                               name="price"
                                               id="price"
                                               class="form-control @error('price') is-invalid @enderror"
                                               value="{{ old('price') }}"
                                               placeholder="0.00"
                                               min="0"
                                               step="0.01"
                                               required>
                                        <span class="input-group-text">ج.م</span>
                                    </div>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">أدخل السعر بالجنية المصرى</small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">مدة التنفيذ (دقيقة)</label>
                                    <div class="input-group">
                                        <input type="number"
                                               name="duration"
                                               class="form-control @error('duration') is-invalid @enderror"
                                               value="{{ old('duration', 30) }}"
                                               placeholder="30"
                                               min="1"
                                               step="1">
                                        <span class="input-group-text">دقيقة</span>
                                    </div>
                                    @error('duration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">المدة التقريبية لتنفيذ الخدمة</small>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">وصف الخدمة</label>
                                    <textarea name="description"
                                              class="form-control @error('description') is-invalid @enderror"
                                              rows="4"
                                              placeholder="وصف مفصل للخدمة...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- <div class="col-md-6 mb-3">
                                    <label class="form-label">التصنيف</label>
                                    <select name="category" class="form-select @error('category') is-invalid @enderror">
                                        <option value="">اختر تصنيفاً</option>
                                        <option value="washing" {{ old('category') == 'washing' ? 'selected' : '' }}>غسيل</option>
                                        <option value="polishing" {{ old('category') == 'polishing' ? 'selected' : '' }}>تلميع</option>
                                        <option value="cleaning" {{ old('category') == 'cleaning' ? 'selected' : '' }}>تنظيف داخلي</option>
                                        <option value="engine" {{ old('category') == 'engine' ? 'selected' : '' }}>تنظيف الموتور</option>
                                        <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>خدمات أخرى</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> --}}

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">الحالة</label>
                                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>نشطة</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>غير نشطة</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- معلومات إضافية -->
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">تفاصيل إضافية</h6>
                        </div>
                        <div class="card-body">
                            <!-- معلومات المغسلة -->
                            <div class="mb-4">
                                <h6 class="mb-3">المغسلة</h6>
                                <div class="alert alert-light">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-building text-primary me-2"></i>
                                        <span>{{ $carWash->name }}</span>
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-muted">{{ $carWash->location }}</small>
                                    </div>
                                </div>
                            </div>

                            <!-- ملاحظات سريعة -->
                            <div class="mb-3">
                                <h6 class="mb-3">ملاحظات</h6>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="is_popular" id="isPopular" {{ old('is_popular') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="isPopular">
                                        خدمة شائعة
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="available_for_online" id="availableOnline" {{ old('available_for_online', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="availableOnline">
                                        متاحة للحجز أونلاين
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- زر الحفظ -->
                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary w-100 py-3" id="submitBtn">
                                <i class="bi bi-save"></i> حفظ الخدمة
                            </button>
                            <a href="{{ route('services.index', $carWash) }}" class="btn btn-outline-secondary w-100 mt-2">
                                <i class="bi bi-arrow-right"></i> إلغاء والعودة
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.input-group-text {
    background-color: #f8f9fa;
    border-color: #dee2e6;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // تنسيق السعر تلقائياً
    const priceInput = document.getElementById('price');

    priceInput.addEventListener('input', function() {
        let value = this.value;
        // إزالة أي أحرف غير رقمية
        value = value.replace(/[^\d.]/g, '');
        // السماح بنقطة واحدة فقط
        const parts = value.split('.');
        if (parts.length > 2) {
            value = parts[0] + '.' + parts.slice(1).join('');
        }
        this.value = value;
    });

    // تحقق من صحة النموذج
    document.getElementById('serviceForm').addEventListener('submit', function(e) {
        const price = parseFloat(priceInput.value);

        if (price < 0) {
            e.preventDefault();
            alert('السعر يجب أن يكون رقم موجب');
            priceInput.focus();
            return false;
        }

        // عرض loading
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.innerHTML = '<i class="bi bi-hourglass"></i> جاري الحفظ...';
        submitBtn.disabled = true;
    });
});
</script>
@endsection
