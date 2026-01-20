@extends('layouts.dashboard')

@section('title', 'إدارة الطلبات - اختر الحالة')
@section('page-title', 'إدارة الطلبات')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">
                    <i class="bi bi-filter-circle"></i> تصفية الطلبات حسب الحالة
                </h5>
                <p class="mb-0 small mt-1">اختر حالة الطلبات التي تريد عرضها</p>
            </div>
            <div>
                <span class="badge bg-light text-primary fs-6">
                    <i class="bi bi-building"></i> {{ $carWash->name }}
                </span>
            </div>
        </div>
    </div>

    <div class="card-body">
        <!-- إحصائيات سريعة -->
        <div class="row mb-5">
            <div class="col-md-3 col-6 mb-3">
                <div class="text-center p-3 border rounded bg-light">
                    <div class="fs-2 fw-bold text-primary">
                        {{ $stats['total'] ?? 0 }}
                    </div>
                    <div class="text-muted small">إجمالي الطلبات</div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="text-center p-3 border rounded bg-light">
                    <div class="fs-2 fw-bold text-warning">
                        {{ $stats['pending'] ?? 0 }}
                    </div>
                    <div class="text-muted small">قيد الانتظار</div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="text-center p-3 border rounded bg-light">
                    <div class="fs-2 fw-bold text-info">
                        {{ $stats['in_progress'] ?? 0 }}
                    </div>
                    <div class="text-muted small">قيد التنفيذ</div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="text-center p-3 border rounded bg-light">
                    <div class="fs-2 fw-bold text-success">
                        {{ $stats['completed'] ?? 0 }}
                    </div>
                    <div class="text-muted small">مكتملة</div>
                </div>
            </div>
        </div>

        <!-- خيارات الحالات -->
        <div class="row g-4">
            <!-- حالة: قيد الانتظار -->
            <div class="col-xl-3 col-md-6">
                <a href="{{ route('carWash.orders.index', ['carWash' => $carWash->id, 'status' => 'pending']) }}"
                   class="card status-card text-decoration-none">
                    <div class="card-body text-center p-4">
                        <div class="status-icon mb-3">
                            <div class="icon-circle bg-warning bg-opacity-10 mx-auto">
                                <i class="bi bi-clock-history fs-1 text-warning"></i>
                            </div>
                        </div>
                        <h5 class="text-warning mb-2">قيد الانتظار</h5>
                        <p class="text-muted small mb-3">
                            الطلبات الجديدة التي تنتظر الموافقة عليها
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-warning rounded-pill px-3 py-2">
                                {{ $stats['pending'] ?? 0 }} طلب
                            </span>
                            <i class="bi bi-arrow-left text-warning"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- حالة: مقبولة -->
            <div class="col-xl-3 col-md-6">
                <a href="{{ route('carWash.orders.index', ['carWash' => $carWash->id, 'status' => 'accepted']) }}"
                   class="card status-card text-decoration-none">
                    <div class="card-body text-center p-4">
                        <div class="status-icon mb-3">
                            <div class="icon-circle bg-info bg-opacity-10 mx-auto">
                                <i class="bi bi-check-circle fs-1 text-info"></i>
                            </div>
                        </div>
                        <h5 class="text-info mb-2">مقبولة</h5>
                        <p class="text-muted small mb-3">
                            الطلبات التي تمت الموافقة عليها وجاهزة للتنفيذ
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-info rounded-pill px-3 py-2">
                                {{ $stats['accepted'] ?? 0 }} طلب
                            </span>
                            <i class="bi bi-arrow-left text-info"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- حالة: قيد التنفيذ -->
            <div class="col-xl-3 col-md-6">
                <a href="{{ route('carWash.orders.index', ['carWash' => $carWash->id, 'status' => 'in-progress']) }}"
                   class="card status-card text-decoration-none">
                    <div class="card-body text-center p-4">
                        <div class="status-icon mb-3">
                            <div class="icon-circle bg-primary bg-opacity-10 mx-auto">
                                <i class="bi bi-gear fs-1 text-primary"></i>
                            </div>
                        </div>
                        <h5 class="text-primary mb-2">قيد التنفيذ</h5>
                        <p class="text-muted small mb-3">
                            الطلبات التي يتم تنفيذها حالياً في المغسلة
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-primary rounded-pill px-3 py-2">
                                {{ $stats['in_progress'] ?? 0 }} طلب
                            </span>
                            <i class="bi bi-arrow-left text-primary"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- حالة: مكتملة -->
            <div class="col-xl-3 col-md-6">
                <a href="{{ route('carWash.orders.index', ['carWash' => $carWash->id, 'status' => 'completed']) }}"
                   class="card status-card text-decoration-none">
                    <div class="card-body text-center p-4">
                        <div class="status-icon mb-3">
                            <div class="icon-circle bg-success bg-opacity-10 mx-auto">
                                <i class="bi bi-check2-all fs-1 text-success"></i>
                            </div>
                        </div>
                        <h5 class="text-success mb-2">مكتملة</h5>
                        <p class="text-muted small mb-3">
                            الطلبات التي تم انتهاء تنفيذها بنجاح
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-success rounded-pill px-3 py-2">
                                {{ $stats['completed'] ?? 0 }} طلب
                            </span>
                            <i class="bi bi-arrow-left text-success"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- حالة: ملغية -->
            <div class="col-xl-3 col-md-6">
                <a href="{{ route('carWash.orders.index', ['carWash' => $carWash->id, 'status' => 'cancelled']) }}"
                   class="card status-card text-decoration-none">
                    <div class="card-body text-center p-4">
                        <div class="status-icon mb-3">
                            <div class="icon-circle bg-danger bg-opacity-10 mx-auto">
                                <i class="bi bi-x-circle fs-1 text-danger"></i>
                            </div>
                        </div>
                        <h5 class="text-danger mb-2">ملغية</h5>
                        <p class="text-muted small mb-3">
                            الطلبات التي تم إلغاؤها من قبل العميل أو المنشأة
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-danger rounded-pill px-3 py-2">
                                {{ $stats['cancelled'] ?? 0 }} طلب
                            </span>
                            <i class="bi bi-arrow-left text-danger"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- عرض الكل -->
            <div class="col-xl-3 col-md-6">
                <a href="{{ route('carWash.orders.index', ['carWash' => $carWash->id, 'status' => 'all']) }}"
                   class="card status-card text-decoration-none">
                    <div class="card-body text-center p-4">
                        <div class="status-icon mb-3">
                            <div class="icon-circle bg-secondary bg-opacity-10 mx-auto">
                                <i class="bi bi-list-check fs-1 text-secondary"></i>
                            </div>
                        </div>
                        <h5 class="text-secondary mb-2">جميع الطلبات</h5>
                        <p class="text-muted small mb-3">
                            عرض جميع الطلبات بجميع الحالات
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-secondary rounded-pill px-3 py-2">
                                {{ $stats['total'] ?? 0 }} طلب
                            </span>
                            <i class="bi bi-arrow-left text-secondary"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- اليوم فقط -->
            <div class="col-xl-3 col-md-6">
                <a href="{{ route('carWash.orders.index', ['carWash' => $carWash->id, 'status' => 'today']) }}"
                   class="card status-card text-decoration-none">
                    <div class="card-body text-center p-4">
                        <div class="status-icon mb-3">
                            <div class="icon-circle bg-success bg-opacity-10 mx-auto">
                                <i class="bi bi-calendar-day fs-1 text-success"></i>
                            </div>
                        </div>
                        <h5 class="text-success mb-2">طلبات اليوم</h5>
                        <p class="text-muted small mb-3">
                            الطلبات المجدولة لليوم {{ date('Y/m/d') }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-success rounded-pill px-3 py-2">
                                {{ $stats['today'] ?? 0 }} طلب
                            </span>
                            <i class="bi bi-arrow-left text-success"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- البحث المتقدم -->
            <div class="col-xl-3 col-md-6">
                <div class="card status-card">
                    <div class="card-body text-center p-4">
                        <div class="status-icon mb-3">
                            <div class="icon-circle bg-primary bg-opacity-10 mx-auto">
                                <i class="bi bi-search fs-1 text-primary"></i>
                            </div>
                        </div>
                        <h5 class="text-primary mb-2">بحث متقدم</h5>
                        <p class="text-muted small mb-3">
                            بحث في الطلبات حسب التاريخ أو العميل
                        </p>
                        <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#searchModal">
                            <i class="bi bi-search"></i> بحث متقدم
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- خيارات سريعة -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">خيارات سريعة</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <a href="{{ route('carwashes.index') }}" class="btn btn-outline-primary w-100">
                                    <i class="bi bi-arrow-right"></i> العودة للمغاسل
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('carWash.show', $carWash) }}" class="btn btn-outline-info w-100">
                                    <i class="bi bi-eye"></i> عرض تفاصيل المغسلة
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('services.index', $carWash) }}" class="btn btn-outline-warning w-100">
                                    <i class="bi bi-bucket"></i> إدارة الخدمات
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- مودال البحث المتقدم -->
<div class="modal fade" id="searchModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">بحث متقدم في الطلبات</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('carWash.orders.index', ['carWash' => $carWash, 'status' => 'pending']) }}" method="GET" id="advancedSearchForm">
                    <div class="mb-3">
                        <label class="form-label">رقم الطلب</label>
                        <input type="text" name="order_id" class="form-control" placeholder="أدخل رقم الطلب">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">اسم العميل</label>
                        <input type="text" name="customer_name" class="form-control" placeholder="بحث باسم العميل">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">من تاريخ</label>
                            <input type="date" name="from_date" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">إلى تاريخ</label>
                            <input type="date" name="to_date" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">الحالة</label>
                        <select name="status" class="form-select">
                            <option value="">جميع الحالات</option>
                            <option value="pending">قيد الانتظار</option>
                            <option value="accepted">مقبولة</option>
                            <option value="in-progress">قيد التنفيذ</option>
                            <option value="completed">مكتملة</option>
                            <option value="cancelled">ملغية</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">نوع المركبة</label>
                        <input type="text" name="vehicle_type" class="form-control" placeholder="مثال: سيدان، دفع رباعي">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="submit" form="advancedSearchForm" class="btn btn-primary">بحث</button>
            </div>
        </div>
    </div>
</div>

<style>
.status-card {
    border: 2px solid transparent;
    border-radius: 15px;
    transition: all 0.3s ease;
    height: 100%;
}

.status-card:hover {
    border-color: var(--bs-primary);
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.icon-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.status-card .card-body {
    padding: 1.5rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // تعيين تاريخ اليوم كقيمة افتراضية
    const today = new Date().toISOString().split('T')[0];
    document.querySelector('input[name="to_date"]').value = today;

    // تعيين تاريخ أول الشهر
    const firstDay = new Date();
    firstDay.setDate(1);
    document.querySelector('input[name="from_date"]').value = firstDay.toISOString().split('T')[0];

    // تأكيد البحث
    document.getElementById('advancedSearchForm').addEventListener('submit', function(e) {
        const fromDate = document.querySelector('input[name="from_date"]').value;
        const toDate = document.querySelector('input[name="to_date"]').value;

        if (fromDate && toDate && new Date(fromDate) > new Date(toDate)) {
            e.preventDefault();
            alert('تاريخ البداية يجب أن يكون قبل تاريخ النهاية');
            return false;
        }
    });
});
</script>
@endsection
