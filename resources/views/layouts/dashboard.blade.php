<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - CarWash Pro</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <style>
        :root {
            --primary-blue: #1a365d;
            --secondary-blue: #2d3748;
            --accent-yellow: #f6c90e;
            --light-gray: #f7fafc;
            --dark-gray: #4a5568;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fb;
        }

        /* Sidebar Styles */
        .sidebar {
            background: var(--primary-blue);
            color: white;
            min-height: 100vh;
            position: fixed;
            right: 0;
            top: 0;
            width: 280px;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .sidebar-menu .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.8rem 1.5rem;
            margin: 0.2rem 0;
            border-radius: 0;
            border-right: 3px solid transparent;
            transition: all 0.3s;
        }

        .sidebar-menu .nav-link:hover,
        .sidebar-menu .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            border-right-color: var(--accent-yellow);
        }

        .sidebar-menu .nav-link i {
            width: 24px;
            text-align: center;
            margin-left: 10px;
        }

        /* Main Content */
        .main-content {
            margin-right: 280px;
            padding: 20px;
            transition: all 0.3s;
        }

        /* Topbar */
        .topbar {
            background: white;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        /* Tables */
        .table-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: var(--dark-gray);
        }

        /* Status Badges */
        .badge-pending {
            background-color: #ffc107;
            color: #000;
        }

        .badge-accepted {
            background-color: #17a2b8;
            color: #fff;
        }

        .badge-in-progress {
            background-color: #007bff;
            color: #fff;
        }

        .badge-completed {
            background-color: #28a745;
            color: #fff;
        }

        .badge-cancelled {
            background-color: #dc3545;
            color: #fff;
        }

        /* Service Tags */
        .service-tag {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            background-color: #e9ecef;
            margin: 0.1rem;
        }

        /* Action Buttons */
        .btn-action {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            margin: 0 0.1rem;
        }

        /* Car Wash Card */
        .carwash-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s;
            height: 100%;
        }

        .carwash-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .carwash-img {
            height: 200px;
            object-fit: cover;
        }

        /* Order Progress */
        .order-progress {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            margin: 2rem 0;
        }

        .order-progress::before {
            content: '';
            position: absolute;
            top: 50%;
            right: 0;
            left: 0;
            height: 3px;
            background: #e9ecef;
            z-index: 1;
        }

        .progress-step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 2;
            font-weight: bold;
        }

        .progress-step.active {
            background: var(--accent-yellow);
            color: var(--primary-blue);
        }

        .progress-step.completed {
            background: var(--primary-blue);
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                margin-right: -280px;
            }

            .sidebar.active {
                margin-right: 0;
            }

            .main-content {
                margin-right: 0;
                padding: 15px;
            }

            .sidebar-toggler {
                display: block !important;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        /* Loading Spinner */
        .spinner-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 200px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* تخصيص حقول الوقت */
        .time-input {
            text-align: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 1rem;
        }

        .time-input:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        /* تنسيق البادجات */
        .badge-info {
            background-color: #36b9cc;
            color: white;
            padding: 0.5em 1em;
            font-size: 0.9rem;
        }

        /* تنسيق الصفوف */
        .table-hover tbody tr:hover {
            background-color: rgba(78, 115, 223, 0.05);
        }

        /* تنسيق البطاقات */
        .card {
            border: none;
            border-radius: 0.5rem;
        }

        .card-header {
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }
    </style>
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
                <!-- Common Links -->
                <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i> لوحة التحكم
                </a>

                <a class="nav-link {{ Request::is('profile*') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                    <i class="bi bi-person"></i> الملف الشخصي
                </a>

                <!-- Customer Specific Links -->
                @if (auth()->user()->role == 'customer')
                    <a class="nav-link {{ Request::is('carwashes*') ? 'active' : '' }}"
                        href="{{ route('carwashes.index') }}">
                        <i class="bi bi-search"></i> تصفح المغاسل
                    </a>

                    <a class="nav-link {{ Request::is('orders*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                        <i class="bi bi-list-check"></i> طلباتي
                    </a>
                @endif

                <!-- Owner Specific Links -->
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

                <!-- Admin Specific Links -->
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

                <!-- Common Bottom Links -->
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

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" class="px-3">
                    @csrf
                    <button type="submit" class="nav-link text-start w-100 bg-transparent border-0">
                        <i class="bi bi-box-arrow-left"></i> تسجيل الخروج
                    </button>
                </form>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Topbar -->
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
                        <div class="dropdown-menu dropdown-menu-end p-0" style="min-width: 300px;">
                            <div class="p-3 border-bottom">
                                <h6 class="mb-0">الإشعارات</h6>
                            </div>
                            <div class="list-group" style="max-height: 300px; overflow-y: auto;">
                                {{-- @foreach (auth()->user()->notifications()->take(5)->get() as $notification)
                                    <a href="#"
                                        class="list-group-item list-group-item-action border-0 {{ $notification->unread() ? 'bg-light' : '' }}">
                                        <div class="d-flex w-100 justify-content-between">
                                            <small
                                                class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-1">{{ $notification->data['message'] ?? 'اشعار جديد' }}</p>
                                    </a>
                                @endforeach --}}
                            </div>
                            <div class="p-2 border-top text-center">
                                <a href="#" class="text-decoration-none">عرض
                                    الكل</a>
                            </div>
                        </div>
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

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('mainContent').classList.toggle('expanded');
        });

        // Auto-hide sidebar on mobile when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');

            if (window.innerWidth < 768 &&
                !sidebar.contains(event.target) &&
                !sidebarToggle.contains(event.target) &&
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });

        // Chart initialization for dashboard
        document.addEventListener('DOMContentLoaded', function() {
            // Check if we're on a page with charts
            const revenueChart = document.getElementById('revenueChart');
            const ordersChart = document.getElementById('ordersChart');

            if (revenueChart) {
                const ctx = revenueChart.getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو'],
                        datasets: [{
                            label: 'الإيرادات',
                            data: [12000, 19000, 15000, 25000, 22000, 30000],
                            borderColor: 'rgb(246, 201, 14)',
                            backgroundColor: 'rgba(246, 201, 14, 0.1)',
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            }
                        }
                    }
                });
            }
        });

        // Update order status
        function updateOrderStatus(orderId, status) {
            if (confirm('هل أنت متأكد من تغيير حالة الطلب؟')) {
                fetch(`/owner/orders/${orderId}/status`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            status: status
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    });
            }
        }

        // Mark notification as read
        function markAsRead(notificationId) {
            fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
        }
    </script>

    @stack('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
</body>

</html>
