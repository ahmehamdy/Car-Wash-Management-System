@extends('layouts.auth')

@section('title', 'تسجيل الدخول')

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
                                <h2 class="fw-bold text-primary">مرحباً بعودتك!</h2>
                                <p class="text-muted">سجل الدخول لحسابك للمتابعة</p>
                            </div>

                            @if(session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    @foreach($errors->all() as $error)
                                        <p class="mb-0">{{ $error }}</p>
                                    @endforeach
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                                @csrf

                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold">البريد الإلكتروني</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-envelope text-muted"></i>
                                        </span>
                                        <input type="email"
                                               class="form-control border-start-0 @error('email') is-invalid @enderror"
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
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label fw-semibold">كلمة المرور</label>
                                    <div class="position-relative">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-lock text-muted"></i>
                                            </span>
                                            <input type="password"
                                                   class="form-control border-start-0 password-input @error('password') is-invalid @enderror"
                                                   id="password"
                                                   name="password"
                                                   placeholder="ادخل كلمة المرور"
                                                   required>
                                        </div>
                                        <span class="password-toggle">
                                            <i class="bi bi-eye"></i>
                                        </span>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                        <label class="form-check-label text-muted" for="remember">
                                            تذكرني
                                        </label>
                                    </div>
                                    <a href="{{ route('password.request') }}" class="text-decoration-none text-primary">
                                        نسيت كلمة المرور؟
                                    </a>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-3 mb-4">
                                    <i class="bi bi-box-arrow-in-right me-2"></i> تسجيل الدخول
                                </button>

                                <div class="text-center mb-4">
                                    <span class="text-muted">أو سجل الدخول باستخدام</span>
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <button type="button" class="social-btn w-100">
                                            <i class="bi bi-google text-danger"></i>
                                            <span>جوجل</span>
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="social-btn w-100">
                                            <i class="bi bi-facebook text-primary"></i>
                                            <span>فيسبوك</span>
                                        </button>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <p class="text-muted">
                                        ليس لديك حساب؟
                                        <a href="{{ route('register') }}" class="text-decoration-none fw-semibold text-primary">
                                            سجل الآن
                                        </a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Right Side - Info -->
                    <div class="col-lg-5 d-none d-lg-block">
                        <div class="auth-sidebar">
                            <h3>لماذا CarWash Pro؟</h3>
                            <ul>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>إدارة سهلة لعمليات غسيل السيارات</span>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>حجز مواعيد أونلاين في أي وقت</span>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>تتبع حالة الخدمة في الوقت الحقيقي</span>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>تقارير وإحصائيات مفصلة</span>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>دعم فني على مدار الساعة</span>
                                </li>
                            </ul>

                            <div class="mt-5 pt-5">
                                <div class="testimonial bg-white bg-opacity-10 p-3 rounded">
                                    <p class="fst-italic">
                                        "CarWash Pro ساعدتني في تنظيم عملي وزادت من عدد عملائي بنسبة 40% خلال شهرين فقط!"
                                    </p>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <img src="https://ui-avatars.com/api/?name=محمد+علي&background=random"
                                                 alt="صاحب مغسلة"
                                                 class="rounded-circle"
                                                 width="40"
                                                 height="40">
                                        </div>
                                        <div>
                                            <h6 class="mb-0">محمد علي</h6>
                                            <small class="text-light">صاحب مغسلة سيارات</small>
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
</div>
@endsection
