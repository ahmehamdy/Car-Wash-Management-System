<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarWash Pro | نظام إدارة مغاسل السيارات</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    @vite('resources/css/welcome.css')
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="bi bi-droplet-half text-warning"></i> CarWash Pro
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">المميزات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#roles">الأدوار</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">اتصل بنا</a>
                    </li>
                </ul>
                <div class="d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-outline-light">تسجيل الدخول</a>
                    <a href="{{ route('register') }}" class="btn btn-warning">إنشاء حساب</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-white" id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 animate-fade-up">
                    <h1 class="display-4 fw-bold mb-4">
                        نظام إدارة مغاسل السيارات المتكامل
                    </h1>
                    <p class="lead mb-4">
                        منصة متكاملة تربط بين أصحاب مغاسل السيارات والعملاء، حيث يمكنك حجز خدمات الغسيل والتلميع أونلاين
                        وإدارة عملك بكفاءة عالية.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('register') }}" class="btn btn-warning btn-lg px-4">
                            <i class="bi bi-lightning-charge"></i> ابدأ الآن مجاناً
                        </a>
                        <a href="#features" class="btn btn-outline-light btn-lg px-4">
                            <i class="bi bi-play-circle"></i> شاهد المميزات
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block animate-fade-up" style="animation-delay: 0.2s;">
                    <div class="card bg-dark bg-opacity-50 border-0 rounded-4 p-4">
                        <div class="card-body">
                            <h4 class="text-warning mb-4">جرب النظام الآن!</h4>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card bg-primary bg-opacity-25 border-primary h-100">
                                        <div class="card-body text-center">
                                            <i class="bi bi-person-plus display-6 text-warning mb-3"></i>
                                            <h5>عميل جديد</h5>
                                            <p class="small">سجل كعميل واحجز خدمة غسيل سيارتك بسهولة</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-success bg-opacity-25 border-success h-100">
                                        <div class="card-body text-center">
                                            <i class="bi bi-building display-6 text-warning mb-3"></i>
                                            <h5>صاحب مغسلة</h5>
                                            <p class="small">انضم كصاحب عمل ووسع نشاطك التجاري</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-md-3 col-6">
                    <div class="p-4">
                        <div class="stat-counter">150+</div>
                        <p class="text-muted">مغسلة سيارات</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="p-4">
                        <div class="stat-counter">5,000+</div>
                        <p class="text-muted">عميل نشط</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="p-4">
                        <div class="stat-counter">25,000+</div>
                        <p class="text-muted">خدمة مقدمة</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="p-4">
                        <div class="stat-counter">98%</div>
                        <p class="text-muted">رضا العملاء</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5" id="features">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="display-5 fw-bold text-primary mb-3">المميزات الرئيسية</h2>
                    <p class="lead text-muted">نظام متكامل يلبي جميع احتياجاتك</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card shadow-sm">
                        <div class="card-body p-4 text-center">
                            <div class="icon-circle bg-accent">
                                <i class="bi bi-calendar-check text-warning" style="font-size: 2rem;"></i>
                            </div>
                            <h4 class="card-title">حجز مواعيد أونلاين</h4>
                            <p class="card-text text-muted">
                                احجز موعد غسيل سيارتك في أي وقت ومن أي مكان، مع نظام حجوزات ذكي يتجنب التداخلات.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card shadow-sm">
                        <div class="card-body p-4 text-center">
                            <div class="icon-circle bg-accent">
                                <i class="bi bi-bar-chart text-warning" style="font-size: 2rem;"></i>
                            </div>
                            <h4 class="card-title">لوحة تحكم متكاملة</h4>
                            <p class="card-text text-muted">
                                لوحة تحكم شاملة لأصحاب المغاسل مع إحصائيات حية وتقارير مفصلة عن الأداء والأرباح.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card shadow-sm">
                        <div class="card-body p-4 text-center">
                            <div class="icon-circle bg-accent">
                                <i class="bi bi-credit-card text-warning" style="font-size: 2rem;"></i>
                            </div>
                            <h4 class="card-title">دفع آمن إلكتروني</h4>
                            <p class="card-text text-muted">
                                نظام دفع إلكتروني آمن ومتعدد الخيارات مع فواتير رقمية وسجل للمعاملات المالية.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card shadow-sm">
                        <div class="card-body p-4 text-center">
                            <div class="icon-circle bg-accent">
                                <i class="bi bi-map text-warning" style="font-size: 2rem;"></i>
                            </div>
                            <h4 class="card-title">تحديد موقع المغاسل</h4>
                            <p class="card-text text-muted">
                                ابحث عن أقرب مغسلة سيارات إليك باستخدام خرائط تفاعلية مع عرض التقييمات والخدمات.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card shadow-sm">
                        <div class="card-body p-4 text-center">
                            <div class="icon-circle bg-accent">
                                <i class="bi bi-bell text-warning" style="font-size: 2rem;"></i>
                            </div>
                            <h4 class="card-title">إشعارات فورية</h4>
                            <p class="card-text text-muted">
                                تتبع حالة طلبك في الوقت الحقيقي مع إشعارات فورية لكل تحديث في حالة الخدمة.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card shadow-sm">
                        <div class="card-body p-4 text-center">
                            <div class="icon-circle bg-accent">
                                <i class="bi bi-star text-warning" style="font-size: 2rem;"></i>
                            </div>
                            <h4 class="card-title">نظام تقييم ومراجعات</h4>
                            <p class="card-text text-muted">
                                قيم تجربتك واقرأ آراء الآخرين قبل الاختيار. نظام تقييم شفاف يعزز الجودة.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- User Roles Section -->
    <section class="py-5 bg-light" id="roles">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="display-5 fw-bold text-primary mb-3">من يمكنه استخدام النظام؟</h2>
                    <p class="lead text-muted">نظام متعدد الأدوار مصمم لجميع الأطراف</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card role-card shadow border-0 bg-white h-100">
                        <div class="card-header bg-primary text-white text-center py-4">
                            <i class="bi bi-person display-4"></i>
                            <h3 class="mt-3">العملاء</h3>
                        </div>
                        <div class="card-body p-4">
                            <ul class="list-unstyled">
                                <li class="mb-3"><i class="bi bi-check-circle text-success me-2"></i> تصفح مغاسل
                                    السيارات المتاحة</li>
                                <li class="mb-3"><i class="bi bi-check-circle text-success me-2"></i> حجز خدمات
                                    أونلاين بسهولة</li>
                                <li class="mb-3"><i class="bi bi-check-circle text-success me-2"></i> تتبع حالة
                                    الطلب في الوقت الحقيقي</li>
                                <li class="mb-3"><i class="bi bi-check-circle text-success me-2"></i> تقييم الخدمات
                                    والمراجعات</li>
                                <li class="mb-3"><i class="bi bi-check-circle text-success me-2"></i> عرض سجل
                                    الحجوزات السابقة</li>
                            </ul>
                            <a href="{{ route('register', ['role' => 'customer']) }}"
                                class="btn btn-outline-primary w-100 mt-3">سجل كعميل</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card role-card shadow border-0 bg-white h-100">
                        <div class="card-header bg-warning text-dark text-center py-4">
                            <i class="bi bi-building display-4"></i>
                            <h3 class="mt-3">أصحاب المغاسل</h3>
                        </div>
                        <div class="card-body p-4">
                            <ul class="list-unstyled">
                                <li class="mb-3"><i class="bi bi-check-circle text-success me-2"></i> إدارة مغاسل
                                    متعددة وفروع</li>
                                <li class="mb-3"><i class="bi bi-check-circle text-success me-2"></i> لوحة تحكم
                                    شاملة مع إحصائيات</li>
                                <li class="mb-3"><i class="bi bi-check-circle text-success me-2"></i> إدارة الحجوزات
                                    والمواعيد</li>
                                <li class="mb-3"><i class="bi bi-check-circle text-success me-2"></i> إدارة الخدمات
                                    والأسعار</li>
                                <li class="mb-3"><i class="bi bi-check-circle text-success me-2"></i> تقارير مالية
                                    وأداء مفصلة</li>
                            </ul>
                            <a href="{{ route('register', ['role' => 'owner']) }}"
                                class="btn btn-warning w-100 mt-3">سجل كصاحب مغسلة</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card role-card shadow border-0 bg-white h-100">
                        <div class="card-header bg-dark text-white text-center py-4">
                            <i class="bi bi-shield-check display-4"></i>
                            <h3 class="mt-3">المديرين</h3>
                        </div>
                        <div class="card-body p-4">
                            <ul class="list-unstyled">
                                <li class="mb-3"><i class="bi bi-check-circle text-success me-2"></i> إدارة جميع
                                    المستخدمين</li>
                                <li class="mb-3"><i class="bi bi-check-circle text-success me-2"></i> الموافقة على
                                    طلبات التسجيل</li>
                                <li class="mb-3"><i class="bi bi-check-circle text-success me-2"></i> مراقبة أداء
                                    النظام بالكامل</li>
                                <li class="mb-3"><i class="bi bi-check-circle text-success me-2"></i> إعدادات النظام
                                    العامة</li>
                                <li class="mb-3"><i class="bi bi-check-circle text-success me-2"></i> تقارير شاملة
                                    عن المنصة</li>
                            </ul>
                            <a href="{{ route('login') }}" class="btn btn-dark w-100 mt-3">دخول المدير</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="display-6 fw-bold">جاهز لبدء رحلتك معنا؟</h2>
                    <p class="lead">انضم إلى منصتنا وابدأ في تحويل تجربة غسيل السيارات إلى تجربة عصرية وسهلة.</p>
                </div>
                <div class="col-lg-4 text-lg-end text-center">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5">
                        <i class="bi bi-rocket-takeoff"></i> ابدأ الآن مجاناً
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h4 class="text-warning mb-4">
                        <i class="bi bi-droplet-half"></i> CarWash Pro
                    </h4>
                    <p>منصة رائدة في إدارة وتنظيم خدمات غسيل السيارات، نهدف إلى ربط العملاء بأفضل مغاسل السيارات مع
                        توفير أدوات متكاملة لإدارة الأعمال.</p>
                    <div class="d-flex gap-3 mt-4">
                        <a href="#" class="text-white"><i class="bi bi-facebook fs-5"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-twitter fs-5"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-instagram fs-5"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-linkedin fs-5"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="text-warning mb-4">روابط سريعة</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#home" class="text-white text-decoration-none">الرئيسية</a>
                        </li>
                        <li class="mb-2"><a href="#features" class="text-white text-decoration-none">المميزات</a>
                        </li>
                        <li class="mb-2"><a href="#roles" class="text-white text-decoration-none">الأدوار</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">الأسعار</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="text-warning mb-4">تواصل معنا</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="bi bi-geo-alt text-warning me-2"></i>
                            الرياض، المملكة العربية السعودية
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-telephone text-warning me-2"></i>
                            +966 500 000 000
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-envelope text-warning me-2"></i>
                            info@carwashpro.com
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h5 class="text-warning mb-4">النشرة البريدية</h5>
                    <p>اشترك لتصلك آخر التحديثات والعروض.</p>
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="بريدك الإلكتروني">
                        <button class="btn btn-warning" type="button">اشترك</button>
                    </div>
                </div>
            </div>
            <hr class="bg-secondary mt-4">
            <div class="row mt-4">
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
</body>
</html>
