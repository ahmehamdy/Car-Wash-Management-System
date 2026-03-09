@extends('layouts.auth')

@section('title', 'إنشاء حساب جديد')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="auth-card">
                <div class="row g-0">
                    <!-- Left Side - Form -->
                    <div class="col-lg-7">
                        <div class="p-4 p-md-5">
                            <div class="text-center mb-5">
                                <h2 class="fw-bold text-primary">إنشاء حساب جديد</h2>
                                <p class="text-muted">اختر نوع حسابك وأكمل المعلومات</p>
                            </div>

                            <!-- Step Indicator -->
                            <div class="step-indicator">
                                <div id="step1" class="step active">1</div>
                                <div id="step2" class="step">2</div>
                                <div id="step3" class="step">3</div>
                            </div>

                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    @foreach($errors->all() as $error)
                                        <p class="mb-0">{{ $error }}</p>
                                    @endforeach
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
                                @csrf

                                <!-- Step 1: Select Role -->
                                <div id="formStep1">
                                    <h5 class="mb-4 text-center">اختر نوع حسابك</h5>
                                    <div class="row g-4 mb-4">
                                        <div class="col-md-6">
                                            <div class="role-card active" data-role="client">
                                                <div class="role-icon">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                                <h5>عميل</h5>
                                                <p class="text-muted small">
                                                    احجز خدمات غسيل السيارات بسهولة وأتبع حالة الخدمة
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="role-card" data-role="owner">
                                                <div class="role-icon">
                                                    <i class="bi bi-building"></i>
                                                </div>
                                                <h5>صاحب مغسلة</h5>
                                                <p class="text-muted small">
                                                    أدير مغسلتك وحجوزات العملاء وتقارير الأداء
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="role" id="role" value="client" required>

                                    <div class="text-center mt-4">
                                        <button type="button" onclick="nextStep(1, 2)" class="btn btn-primary px-5">
                                            التالي <i class="bi bi-arrow-left ms-2"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Step 2: Personal Information -->
                                <div id="formStep2" class="d-none">
                                    <h5 class="mb-4 text-center">معلوماتك الشخصية</h5>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">الاسم الكامل</label>
                                            <input type="text"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   id="name"
                                                   name="name"
                                                   value="{{ old('name') }}"
                                                   placeholder="ادخل اسمك الكامل"
                                                   required>
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">رقم الهاتف</label>
                                            <input type="tel"
                                                   class="form-control @error('phone') is-invalid @enderror"
                                                   id="phone"
                                                   name="phone"
                                                   value="{{ old('phone') }}"
                                                   placeholder="05xxxxxxxx"
                                                   required>
                                            @error('phone')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label for="email" class="form-label">البريد الإلكتروني</label>
                                            <input type="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   id="email"
                                                   name="email"
                                                   value="{{ old('email') }}"
                                                   placeholder="ادخل بريدك الإلكتروني"
                                                   required>
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="password" class="form-label">كلمة المرور</label>
                                            <div class="position-relative">
                                                <input type="password"
                                                       class="form-control password-input @error('password') is-invalid @enderror"
                                                       id="password"
                                                       name="password"
                                                       placeholder="8 أحرف على الأقل"
                                                       required
                                                       minlength="8">
                                                <span class="password-toggle">
                                                    <i class="bi bi-eye"></i>
                                                </span>
                                                @error('password')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-text">يجب أن تحتوي على 8 أحرف على الأقل</div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                                            <div class="position-relative">
                                                <input type="password"
                                                       class="form-control password-input"
                                                       id="password_confirmation"
                                                       name="password_confirmation"
                                                       placeholder="أعد إدخال كلمة المرور"
                                                       required>
                                                <span class="password-toggle">
                                                    <i class="bi bi-eye"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="city" class="form-label">المدينة</label>
                                            <input class="form-control @error('city') is-invalid @enderror"
                                                    id="city"
                                                    name="city"
                                                    required>
                                                </input>
                                            @error('city')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-6">
                                            <button type="button" onclick="prevStep(2, 1)" class="btn btn-outline-primary w-100">
                                                <i class="bi bi-arrow-right me-2"></i> السابق
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <button type="button" onclick="nextStep(2, 3)" class="btn btn-primary w-100">
                                                التالي <i class="bi bi-arrow-left ms-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 3: Terms and Submit -->
                                <div id="formStep3" class="d-none">
                                    <h5 class="mb-4 text-center">الشروط والموافقة</h5>

                                    <div class="card border-0 bg-light mb-4">
                                        <div class="card-body">
                                            <h6>معلومات مهمة:</h6>
                                            <ul class="text-muted small mb-0">
                                                <li>سيتم التحقق من رقم الهاتف عبر رسالة نصية</li>
                                                <li>يجب التأكد من صحة البيانات المدخلة</li>
                                                <li>لن يتم مشاركة معلوماتك مع أطراف ثالثة</li>
                                                <li>يمكنك تحديث بياناتك في أي وقت من إعدادات الحساب</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input @error('terms') is-invalid @enderror"
                                                   type="checkbox"
                                                   id="terms"
                                                   name="terms"
                                                   required>
                                            <label class="form-check-label" for="terms">
                                                أوافق على
                                                <a href="#" class="text-decoration-none text-primary">شروط الاستخدام</a>
                                                و
                                                <a href="#" class="text-decoration-none text-primary">سياسة الخصوصية</a>
                                            </label>
                                            @error('terms')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-check mt-2">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   id="newsletter"
                                                   name="newsletter"
                                                   checked>
                                            <label class="form-check-label" for="newsletter">
                                                أرغب في تلقي العروض والتحديثات عبر البريد الإلكتروني
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-6">
                                            <button type="button" onclick="prevStep(3, 2)" class="btn btn-outline-primary w-100">
                                                <i class="bi bi-arrow-right me-2"></i> السابق
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <button type="submit" class="btn btn-primary w-100 py-3">
                                                <i class="bi bi-person-plus me-2"></i> إنشاء الحساب
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="text-center mt-4">
                                <p class="text-muted">
                                    لديك حساب بالفعل؟
                                    <a href="{{ route('login') }}" class="text-decoration-none fw-semibold text-primary">
                                        سجل الدخول
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Info -->
                    <div class="col-lg-5 d-none d-lg-block">
                        <div class="auth-sidebar">
                            <h3>مزايا التسجيل</h3>
                            <ul>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>حجز سريع وسهل للخدمات</span>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>تتبع حالة الخدمة لحظة بلحظة</span>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>عروض حصرية للأعضاء</span>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>سجل كامل للخدمات السابقة</span>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>تقييمات ومراجعات موثوقة</span>
                                </li>
                            </ul>

                            <div class="mt-5 pt-5">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="me-3">
                                        <i class="bi bi-shield-check display-4 text-warning"></i>
                                    </div>
                                    <div>
                                        <h5>حماية وأمان</h5>
                                        <p class="text-light small mb-0">بياناتك محمية بأعلى معايير الأمان</p>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="bi bi-headset display-4 text-warning"></i>
                                    </div>
                                    <div>
                                        <h5>دعم فني</h5>
                                        <p class="text-light small mb-0">متاح على مدار الساعة طوال الأسبوع</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize first step
        document.getElementById('formStep1').classList.remove('d-none');
    });
</script>
@endpush
