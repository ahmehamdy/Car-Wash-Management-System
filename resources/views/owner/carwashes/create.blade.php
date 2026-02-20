@extends('layouts.dashboard')

@section('title', 'إضافة مغسلة جديدة')
@section('page-title', 'إضافة مغسلة جديدة')

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-plus-lg"></i> إضافة مغسلة جديدة
            </h5>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if ($errors->any())
                <div>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('carWash.store') }}" method="POST" enctype="multipart/form-data" id="carWashForm">
                @csrf

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
                                            value="{{ old('name') }}" placeholder="أدخل اسم المغسلة" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">رقم الهاتف <span class="text-danger">*</span></label>
                                        <input type="text" name="phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone') }}" placeholder="05XXXXXXXX" required>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label">الموقع <span class="text-danger">*</span></label>
                                        <input type="text" name="address"
                                            class="form-control @error('location') is-invalid @enderror"
                                            value="{{ old('location') }}" placeholder="أدخل العنوان الكامل للمغسلة"
                                            required>
                                        @error('location')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label">الوصف</label>
                                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4"
                                            placeholder="وصف مختصر للمغسلة والخدمات المقدمة">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <input type="text" name="lat" id="lat" class="form-control" hidden>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <input type="text" name="lng" id="lng" class="form-control" hidden>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">حدد الموقع على الخريطة</label>
                                        <div id="map" style="height: 350px; border-radius: 10px;"></div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">الحالة <span class="text-danger">*</span></label>
                                        <select name="status" class="form-select @error('status') is-invalid @enderror"
                                            required>
                                            <option value="">اختر الحالة</option>
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>نشطة
                                            </option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                                غير نشطة</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">صور المغسلة</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">اختر صور المغسلة</label>
                                    <input type="file" name="images[]"
                                        class="form-control @error('images.*') is-invalid @enderror" multiple
                                        accept="image/*" id="imageUpload">
                                    <div class="form-text">
                                        يمكنك رفع أكثر من صورة. الصيغ المسموحة: JPG, PNG, GIF. الحد الأقصى: 2MB للصورة
                                    </div>
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
                                <h6 class="mb-0">تفاصيل إضافية</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <h6 class="mb-3">ساعات العمل</h6>
                                    <div class="alert alert-info">
                                        <i class="bi bi-info-circle"></i>
                                        <small>يمكنك تحديد ساعات العمل بعد إنشاء المغسلة من صفحة إدارة مواعيد العمل</small>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h6 class="mb-3">الخدمات</h6>
                                    <div class="alert alert-info">
                                        <i class="bi bi-info-circle"></i>
                                        <small>يمكنك إضافة الخدمات بعد إنشاء المغسلة من صفحة إدارة الخدمات</small>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h6 class="mb-3">إعدادات سريعة</h6>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" name="accept_online_orders"
                                            id="acceptOnlineOrders" checked>
                                        <label class="form-check-label" for="acceptOnlineOrders">
                                            قبول الطلبات أونلاين
                                        </label>
                                    </div>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="show_in_search"
                                            id="showInSearch" checked>
                                        <label class="form-check-label" for="showInSearch">
                                            الظهور في نتائج البحث
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary w-100 py-3">
                                    <i class="bi bi-save"></i> حفظ المغسلة
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

    <style>
        #imagePreview .image-preview-item {
            position: relative;
            margin-bottom: 10px;
        }

        #imagePreview .image-preview-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }

        #imagePreview .remove-image {
            position: absolute;
            top: 5px;
            left: 5px;
            background: rgba(255, 0, 0, 0.8);
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const defaultLat = 30.0444;
            const defaultLng = 31.2357;

            const map = L.map('map').setView([defaultLat, defaultLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            let marker = L.marker([defaultLat, defaultLng], {
                draggable: true
            }).addTo(map);

            document.getElementById('lat').value = defaultLat;
            document.getElementById('lng').value = defaultLng;

            marker.on('dragend', function(e) {
                const position = marker.getLatLng();
                document.getElementById('lat').value = position.lat;
                document.getElementById('lng').value = position.lng;
            });

            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                document.getElementById('lat').value = e.latlng.lat;
                document.getElementById('lng').value = e.latlng.lng;
            });

        });

        document.addEventListener('DOMContentLoaded', function() {
            const imageUpload = document.getElementById('imageUpload');
            const imagePreview = document.getElementById('imagePreview');

            imageUpload.addEventListener('change', function() {
                imagePreview.innerHTML = '';

                if (this.files) {
                    Array.from(this.files).forEach((file, index) => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const div = document.createElement('div');
                            div.className = 'col-md-4 image-preview-item';
                            div.innerHTML = `
                        <img src="${e.target.result}" alt="Preview">
                        <button type="button" class="remove-image" data-index="${index}">
                            <i class="bi bi-x"></i>
                        </button>
                    `;
                            imagePreview.appendChild(div);
                        }
                        reader.readAsDataURL(file);
                    });
                }
            });

            imagePreview.addEventListener('click', function(e) {
                if (e.target.closest('.remove-image')) {
                    const index = e.target.closest('.remove-image').getAttribute('data-index');
                    const dt = new DataTransfer();
                    const files = imageUpload.files;

                    for (let i = 0; i < files.length; i++) {
                        if (i != index) {
                            dt.items.add(files[i]);
                        }
                    }

                    imageUpload.files = dt.files;
                    e.target.closest('.image-preview-item').remove();

                    imageUpload.dispatchEvent(new Event('change'));
                }
            });

            document.getElementById('carWashForm').addEventListener('submit', function(e) {
                const phone = document.querySelector('input[name="phone"]').value;
                const phoneRegex = /^01[0-2,5]\d{8}$/;

                if (!phoneRegex.test(phone)) {
                    e.preventDefault();
                    alert('رقم الهاتف يجب أن يكون 11 أرقام ويبدأ بـ 01');
                    return false;
                }
            });
        });
    </script>
@endsection
