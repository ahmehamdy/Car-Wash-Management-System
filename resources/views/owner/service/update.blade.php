@extends('layouts.dashboard')

@section('title', 'تعديل خدمة')
@section('page-title', 'تعديل خدمة - ' . $carWash->name)

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-pencil"></i> تعديل خدمة: {{ $service->name }}
            </h5>
            <a href="{{ route('services.index', $carWash) }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-right"></i> العودة للخدمات
            </a>
        </div>
    </div>

    <div class="card-body">
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

        <form action="{{ route('services.update', ['carWash' => $carWash, 'service' => $service]) }}" method="POST" id="serviceForm">
            @csrf
            @method('PUT')

            <div class="row">
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
                                           value="{{ old('name', $service->name) }}"
                                           placeholder="أدخل اسم الخدمة"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">السعر (جنية مصرى) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number"
                                               name="price"
                                               id="price"
                                               class="form-control @error('price') is-invalid @enderror"
                                               value="{{ old('price', $service->price) }}"
                                               placeholder="0.00"
                                               min="0"
                                               step="0.01"
                                               required>
                                        <span class="input-group-text">ج.م</span>
                                    </div>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">مدة التنفيذ (دقيقة)</label>
                                    <div class="input-group">
                                        <input type="number"
                                               name="duration"
                                               class="form-control @error('duration') is-invalid @enderror"
                                               value="{{ old('duration', $service->duration ?? 30) }}"
                                               placeholder="30"
                                               min="1"
                                               step="1">
                                        <span class="input-group-text">دقيقة</span>
                                    </div>
                                    @error('duration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">وصف الخدمة</label>
                                    <textarea name="description"
                                              class="form-control @error('description') is-invalid @enderror"
                                              rows="4"
                                              placeholder="وصف مفصل للخدمة...">{{ old('description', $service->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">الحالة</label>
                                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                                        <option value="active" {{ old('status', $service->status ?? 'active') == 'active' ? 'selected' : '' }}>نشطة</option>
                                        <option value="inactive" {{ old('status', $service->status) == 'inactive' ? 'selected' : '' }}>غير نشطة</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">معلومات الخدمة</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h6 class="mb-3">إحصائيات</h6>
                                <div class="alert alert-light">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>تاريخ الإضافة:</span>
                                        <span>{{ $service->created_at->format('Y/m/d') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>آخر تحديث:</span>
                                        <span>{{ $service->updated_at->format('Y/m/d') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>عدد الطلبات:</span>
                                        <span class="badge bg-info">{{ $service->orders_count ?? 0 }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <h6 class="mb-3">ملاحظات</h6>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="is_popular" id="isPopular" {{ old('is_popular', $service->is_popular ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="isPopular">
                                        خدمة شائعة
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="available_for_online" id="availableOnline" {{ old('available_for_online', $service->available_for_online ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="availableOnline">
                                        متاحة للحجز أونلاين
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary w-100 py-3" id="submitBtn">
                                <i class="bi bi-save"></i> حفظ التعديلات
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const priceInput = document.getElementById('price');

    priceInput.addEventListener('input', function() {
        let value = this.value;
        value = value.replace(/[^\d.]/g, '');
        const parts = value.split('.');
        if (parts.length > 2) {
            value = parts[0] + '.' + parts.slice(1).join('');
        }
        this.value = value;
    });

    document.getElementById('serviceForm').addEventListener('submit', function(e) {
        const price = parseFloat(priceInput.value);

        if (price < 0) {
            e.preventDefault();
            alert('السعر يجب أن يكون رقم موجب');
            priceInput.focus();
            return false;
        }

        const submitBtn = document.getElementById('submitBtn');
        submitBtn.innerHTML = '<i class="bi bi-hourglass"></i> جاري الحفظ...';
        submitBtn.disabled = true;
    });
});
</script>
@endsection
