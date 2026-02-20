@extends('layouts.dashboard')

@section('title', 'تعديل مغسلة')
@section('page-title', 'تعديل مغسلة')

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-pencil"></i> تعديل مغسلة: {{ $carWash->name }}
                </h5>
                <a href="{{ route('carWash.show', $carWash) }}" class="btn btn-light btn-sm">
                    <i class="bi bi-eye"></i> عرض التفاصيل
                </a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('carWash.update', $carWash) }}" method="POST" enctype="multipart/form-data"
                id="carWashForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">المعلومات الأساسية</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">اسم المغسلة <span class="text-danger">*</span></label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $carWash->name) }}" placeholder="أدخل اسم المغسلة"
                                            required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">رقم الهاتف <span class="text-danger">*</span></label>
                                        <input type="text" name="phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone', $carWash->phone) }}" placeholder="01XXXXXXXX" required>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label">الموقع <span class="text-danger">*</span></label>
                                        <input type="text" name="address"
                                            class="form-control @error('address') is-invalid @enderror"
                                            value="{{ old('address', $carWash->address) }}"
                                            placeholder="أدخل العنوان الكامل للمغسلة" required>
                                        @error('location')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label">الوصف</label>
                                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4"
                                            placeholder="وصف مختصر للمغسلة والخدمات المقدمة">{{ old('description', $carWash->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <input type="hidden" name="lat" id="lat"
                                        value="{{ old('lat', $carWash->lat) }}">
                                    <input type="hidden" name="lng" id="lng"
                                        value="{{ old('lng', $carWash->lng) }}">
                                    <div class="mb-3">
                                        <label class="form-label">موقع المغسلة على الخريطة</label>
                                        <div id="map" style="height: 350px; width: 100%; border-radius: 10px;"></div>
                                    </div>


                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">الحالة <span class="text-danger">*</span></label>

                                        <select name="is_active"
                                            class="form-select @error('is_active') is-invalid @enderror" required>

                                            <option value="">اختر الحالة</option>

                                            <option value="1"
                                                {{ old('is_active', $carWash->is_active) == 1 ? 'selected' : '' }}>
                                                نشطة
                                            </option>

                                            <option value="0"
                                                {{ old('is_active', $carWash->is_active) == 0 ? 'selected' : '' }}>
                                                غير نشطة
                                            </option>
                                        </select>

                                        @error('is_active')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        </div>

                        @php
                            $currentImages = $carWash->images;
                        @endphp
                        @php
                            $currentImages = $carWash->images ?? [];
                        @endphp

                        <div class="card mb-4">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">الصور الحالية</h6>
                                <span class="badge bg-primary">{{ count($currentImages) }} صورة</span>
                            </div>
                            <div class="card-body">
                                @if (count($currentImages) == 0)
                                    <div class="text-center py-3">
                                        <i class="bi bi-images display-4 text-muted"></i>
                                        <p class="text-muted mt-2">لا توجد صور للمغسلة</p>
                                    </div>
                                @else
                                    <div class="row">
                                        @foreach ($currentImages as $index => $imagePath)
                                            <div class="col-md-3 col-6 mb-3">
                                                <div class="position-relative">
                                                    <img src="{{ asset('storage/' . trim($imagePath)) }}"
                                                        alt="صورة المغسلة {{ $index + 1 }}" class="img-fluid rounded"
                                                        style="height: 150px; width: 100%; object-fit: cover;">
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm position-absolute top-0 start-0 m-2"
                                                        onclick="deleteImage('{{ $imagePath }}')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                    <input type="hidden" name="current_images[]"
                                                        value="{{ trim($imagePath) }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <small class="text-muted">انقر على أيقونة السلة لحذف صورة</small>
                                @endif
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">إضافة صور جديدة</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">اختر صور إضافية</label>
                                    <input type="file" name="images[]"
                                        class="form-control @error('images') is-invalid @enderror" multiple
                                        accept="image/*" id="imageUpload">
                                    <div class="form-text">
                                        يمكنك رفع أكثر من صورة. الصيغ المسموحة: JPG, PNG, GIF, WEBP. الحد الأقصى: 2MB للصورة
                                    </div>
                                    @error('images')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @error('images.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row" id="imagePreview">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">روابط سريعة</h6>
                            </div>
                            <div class="card-body">
                                <div class="list-group">
                                    <a href="{{ route('services.index', $carWash) }}"
                                        class="list-group-item list-group-item-action">
                                        <i class="bi bi-bucket me-2"></i> إدارة الخدمات
                                    </a>
                                    <a href="{{ route('car-wash-working-hours.index', $carWash) }}"
                                        class="list-group-item list-group-item-action">
                                        <i class="bi bi-clock me-2"></i> مواعيد العمل
                                    </a>
                                    <a href="{{ route('carWash.orders.selectStatus', $carWash) }}"
                                        class="list-group-item list-group-item-action">
                                        <i class="bi bi-receipt me-2"></i> إدارة الطلبات
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary w-100 py-3">
                                    <i class="bi bi-save"></i> حفظ التعديلات
                                </button>
                                <a href="{{ route('carwashes.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                                    <i class="bi bi-arrow-right"></i> إلغاء والعودة
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                let lat = parseFloat(document.getElementById('lat').value) || 30.0444;
                let lng = parseFloat(document.getElementById('lng').value) || 31.2357;

                let map = L.map('map').setView([lat, lng], 14);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                let marker = L.marker([lat, lng], {
                    draggable: true
                }).addTo(map);

                marker.on('dragend', function(e) {
                    let position = marker.getLatLng();
                    document.getElementById('lat').value = position.lat;
                    document.getElementById('lng').value = position.lng;
                });

                map.on('click', function(e) {
                    marker.setLatLng(e.latlng);
                    document.getElementById('lat').value = e.latlng.lat;
                    document.getElementById('lng').value = e.latlng.lng;
                });

            });

            let deletedImages = [];

            function deleteImage(index) {
                if (confirm('هل أنت متأكد من حذف هذه الصورة؟')) {
                    const imageContainer = document.querySelector(`input[name="current_images[]"][value="${index}"]`).closest(
                        '.col-md-3');
                    imageContainer.style.display = 'none';

                    const imagePath = document.querySelector(`input[name="current_images[]"][value="${index}"]`).value;
                    deletedImages.push(imagePath);

                    if (!document.querySelector('input[name="deleted_images"]')) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'deleted_images';
                        input.value = JSON.stringify(deletedImages);
                        document.getElementById('carWashForm').appendChild(input);
                    } else {
                        document.querySelector('input[name="deleted_images"]').value = JSON.stringify(deletedImages);
                    }
                }
            }

            document.getElementById('imageUpload').addEventListener('change', function(e) {
                const files = e.target.files;
                const previewContainer = document.getElementById('imagePreview');
                previewContainer.innerHTML = '';

                if (files.length > 10) {
                    alert('يمكنك رفع حتى 10 صور فقط');
                    this.value = '';
                    return;
                }

                if (files.length > 0) {
                    Array.from(files).forEach((file, index) => {
                        if (file.size > 2 * 1024 * 1024) { // 2MB
                            alert(`الصورة ${file.name} حجمها أكبر من 2 ميجابايت`);
                            return;
                        }

                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const col = document.createElement('div');
                            col.className = 'col-md-3 col-6 mb-3';

                            col.innerHTML = `
        <div class="position-relative">
            <img src="${e.target.result}" alt="Preview ${index}" class="img-fluid rounded"
                style="height: 150px; width: 100%; object-fit: cover;">
            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 start-0 m-2"
                onclick="removeNewImage(${index})">
                <i class="bi bi-trash"></i>
            </button>
        </div>
        `;

                            previewContainer.appendChild(col);
                        };
                        reader.readAsDataURL(file);
                    });
                }
            });

            function removeNewImage(index) {
                const fileInput = document.getElementById('imageUpload');
                const dt = new DataTransfer();
                const files = fileInput.files;

                Array.from(files).forEach((file, i) => {
                    if (i !== index) {
                        dt.items.add(file);
                    }
                });

                fileInput.files = dt.files;

                const event = new Event('change');
                fileInput.dispatchEvent(event);
            }

            document.getElementById('carWashForm').addEventListener('submit', function(e) {
                const name = document.querySelector('input[name="name"]').value.trim();
                const phone = document.querySelector('input[name="phone"]').value.trim();
                const location = document.querySelector('input[name="location"]').value.trim();
                const status = document.querySelector('select[name="status"]').value;

                if (!name || !phone || !location || !status) {
                    e.preventDefault();
                    alert('يرجى ملء جميع الحقول الإلزامية (*)');
                    return;
                }

                if (!confirm('هل أنت متأكد من حفظ التغييرات؟')) {
                    e.preventDefault();
                }
            });
        </script>
    @endpush

    <style>
        .position-relative:hover .btn-danger {
            display: block !important;
        }

        .position-relative .btn-danger {
            display: none;
            transition: all 0.3s ease;
        }
    </style>
@endsection
