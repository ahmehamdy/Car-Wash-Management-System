<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - CarWash Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    @vite(['resources/css/auth.css','resources/js/auth.js'])
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
                <i class="bi bi-droplet-half text-warning"></i> CarWash Pro
            </a>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted d-none d-md-block">ليس لديك حساب؟</span>
                <a href="{{ route('register') }}" class="btn btn-outline-primary">تسجيل جديد</a>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1 py-5">
        <div class="auth-container">
            @yield('content')
        </div>
    </main>

    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">© 2023 CarWash Pro. جميع الحقوق محفوظة.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-white text-decoration-none me-3">سياسة الخصوصية</a>
                    <a href="#" class="text-white text-decoration-none">شروط الاستخدام</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
