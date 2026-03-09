<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - CarWash Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    @vite(['resources/css/dashboard.css','resources/js/dashboard.js'])
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="d-flex align-items-center">
                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=random" alt="Profile"
                    class="rounded-circle me-3" width="40" height="40">
                <div>
                    <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                    <small class="text-gray-500">
                        @if (auth()->user()->role == 'owner')
                            صاحب مغسلة
                        @elseif(auth()->user()->role == 'client')
                            عميل
                        @elseif(auth()->user()->role == 'admin')
                            مدير النظام
                        @endif
                    </small>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">
            <nav class="nav flex-column">
                <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i> لوحة التحكم
                </a>

                <a class="nav-link {{ Request::is('profile*') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                    <i class="bi bi-person"></i> الملف الشخصي
                </a>

                @if (auth()->user()->role == 'client')
                    <a class="nav-link {{ Request::is('carwashes*') ? 'active' : '' }}"
                        href="{{ route('carwashes.index') }}">
                        <i class="bi bi-search"></i> تصفح المغاسل
                    </a>

                    <a class="nav-link {{ Request::is('orders*') ? 'active' : '' }}" href="{{ route('client.orders.index') }}">
                        <i class="bi bi-list-check"></i> طلباتي
                    </a>
                @endif

                @if (auth()->user()->role == 'owner')
                    <a class="nav-link {{ Request::is('owner/carwashes*') ? 'active' : '' }}"
                        href="{{ route('carwashes.index') }}">
                        <i class="bi bi-building"></i> مغاسلي
                    </a>

                    <a class="nav-link {{ Request::is('owner/orders*') ? 'active' : '' }}" href="#">
                        <i class="bi bi-receipt"></i> الطلبات
                    </a>

                    <a class="nav-link {{ Request::is('owner/analytics*') ? 'active' : '' }}" href="#">
                        <i class="bi bi-graph-up"></i> التحليلات
                    </a>

                    <a class="nav-link {{ Request::is('owner/employees*') ? 'active' : '' }}" href="#">
                        <i class="bi bi-people"></i> الموظفين
                    </a>
                @endif

                @if (auth()->user()->role == 'admin')
                    <a class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}" href="">
                        <i class="bi bi-people"></i> إدارة المستخدمين
                    </a>

                    <a class="nav-link {{ Request::is('admin/carwashes*') ? 'active' : '' }}" href="">
                        <i class="bi bi-shop"></i> إدارة المغاسل
                    </a>

                    <a class="nav-link {{ Request::is('admin/settings*') ? 'active' : '' }}" href="">
                        <i class="bi bi-gear"></i> إعدادات النظام
                    </a>
                @endif

                <hr class="text-white-50 my-3">

                <a class="nav-link {{ Request::is('notifications*') ? 'active' : '' }}" href="#">
                    <i class="bi bi-bell"></i> الإشعارات
                    {{-- @if (auth()->user()->unreadNotifications()->count() > 0)
                        <span class="badge bg-danger float-start">
                            {{ auth()->user()->unreadNotifications()->count() }}
                        </span>
                    @endif --}}
                </a>

                <a class="nav-link {{ Request::is('support*') ? 'active' : '' }}" href="#">
                    <i class="bi bi-headset"></i> الدعم الفني
                </a>

                <hr class="text-white-50 my-3">

                <form method="POST" action="{{ route('logout') }}" class="px-3">
                    @csrf
                    <button type="submit" class="nav-link text-start w-100 bg-transparent border-0">
                        <i class="bi bi-box-arrow-left"></i> تسجيل الخروج
                    </button>
                </form>
            </nav>
        </div>
    </div>

    <div class="main-content" id="mainContent">
        <div class="topbar">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <button class="btn btn-outline-primary sidebar-toggler d-none d-md-block" id="sidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <h4 class="mb-0">@yield('page-title', 'لوحة التحكم')</h4>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <!-- Notifications Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-light position-relative" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-bell"></i>
                            {{-- @if (auth()->user()->unreadNotifications()->count() > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ auth()->user()->unreadNotifications()->count() }}
                                </span>
                            @endif --}}
                        </button>

                    </div>

                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-light d-flex align-items-center" type="button"
                            data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=random"
                                alt="Profile" class="rounded-circle me-2" width="32" height="32">
                            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                            <i class="bi bi-chevron-down me-2"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i
                                        class="bi bi-person me-2"></i> الملف الشخصي</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> الإعدادات</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-left me-2"></i> تسجيل الخروج
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="container-fluid">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="mt-5 pt-3 border-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-muted mb-0">© 2023 CarWash Pro. جميع الحقوق محفوظة.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="text-muted mb-0">الإصدار 1.0.0</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    @stack('scripts')
</body>

</html>
