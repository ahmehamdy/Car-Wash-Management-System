@extends('layouts.dashboard')

@section('title', 'تفاصيل الطلب')
@section('page-title', 'تفاصيل الطلب #ORD-2024-001')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <!-- معلومات الطلب الأساسية -->
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">معلومات الطلب</h5>
                    <span class="badge bg-warning fs-6 p-2">قيد الانتظار</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="120">رقم الطلب:</th>
                                    <td><strong>#ORD-2024-001</strong></td>
                                </tr>
                                <tr>
                                    <th>تاريخ الطلب:</th>
                                    <td>{{ \Carbon\Carbon::parse($order->pickup_time)->locale('ar')->translatedFormat('d F Y - h:i A') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>موعد التنفيذ:</th>
                                    <td>{{ $order->pickup_time->copy()->addDay()->locale('ar')->translatedFormat('d F Y - h:i A') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>المغسلة:</th>
                                    <td>{{ $order->carWash->name }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th>الخدمة:</th>
                                    <td>غسيل خارجي + تلميع داخلي</td>
                                </tr>
                                <tr>
                                    <th>السيارة:</th>
                                    <td>تويوتا كامري 2023 - لوحة أ ب ج 1234</td>
                                </tr>
                                <tr>
                                    <th>المبلغ:</th>
                                    <td>
                                        <h4 class="text-primary mb-0">{{$order->total_price}} ج.م</h4>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- تفاصيل الخدمة -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">تفاصيل الخدمة</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>الخدمة</th>
                                    <th>الوصف</th>
                                    <th class="text-end">السعر</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->services as $service)
                                    <tr>
                                        <td>{{$service->name}}</td>
                                        <td>{{$service->description}}</td>
                                        <td class="text-end">{{$service->price}} ج.م</td>
                                    </tr>

                                @endforeach
                                <tr class="table-primary">
                                    <td colspan="2" class="fw-bold">الإجمالي</td>
                                    <td class="text-end fw-bold">{{$order->total_price}} ج.م</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- تتبع الطلب -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">تتبع الطلب</h5>
                </div>
                <div class="card-body">
                    <div class="tracking-steps">
                        <div class="row">
                            <div class="col-3 text-center">
                                <div class="step-icon bg-primary text-white rounded-circle mx-auto mb-2"
                                    style="width: 40px; height: 40px; line-height: 40px;">
                                    <i class="bi bi-check-lg"></i>
                                </div>
                                <small class="d-block">تم الاستلام</small>
                                <small class="text-muted">15/02 10:30</small>
                            </div>
                            <div class="col-3 text-center">
                                <div class="step-icon bg-warning text-white rounded-circle mx-auto mb-2"
                                    style="width: 40px; height: 40px; line-height: 40px;">
                                    <i class="bi bi-hourglass"></i>
                                </div>
                                <small class="d-block">قيد المراجعة</small>
                                <small class="text-muted">15/02 11:15</small>
                            </div>
                            <div class="col-3 text-center">
                                <div class="step-icon bg-light text-muted rounded-circle mx-auto mb-2"
                                    style="width: 40px; height: 40px; line-height: 40px;">
                                    <i class="bi bi-gear"></i>
                                </div>
                                <small class="d-block">قيد التنفيذ</small>
                                <small class="text-muted">--</small>
                            </div>
                            <div class="col-3 text-center">
                                <div class="step-icon bg-light text-muted rounded-circle mx-auto mb-2"
                                    style="width: 40px; height: 40px; line-height: 40px;">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <small class="d-block">مكتمل</small>
                                <small class="text-muted">--</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- معلومات العميل -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">معلومات العميل</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://ui-avatars.com/api/?name=أحمد+محمد&background=random" class="rounded-circle me-3"
                            width="60" height="60">
                        <div>
                            <h6 class="mb-1">{{ $order->user->name }}</h6>
                            <small class="text-muted"><i class="bi bi-telephone"></i> {{ $order->user->phone }}</small><br>
                            <small class="text-muted"><i class="bi bi-envelope"></i> {{ $order->user->email }}</small>
                        </div>
                    </div>
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-geo-alt"></i>{{ $order->user->city }}
                    </div>
                </div>
            </div>

            <!-- إجراءات الطلب -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">إجراءات</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('client.order.edit', $order->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> تعديل الطلب
                        </a>
                        <button class="btn btn-danger" onclick="confirmCancel()">
                            <i class="bi bi-x-circle"></i> إلغاء الطلب
                        </button>
                        <button class="btn btn-outline-primary">
                            <i class="bi bi-printer"></i> طباعة الفاتورة
                        </button>
                    </div>
                </div>
            </div>

            <!-- ملاحظات -->
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">ملاحظات</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <textarea class="form-control" rows="3" placeholder="أضف ملاحظة...">يفضل التواصل قبل القدوم</textarea>
                    </div>
                    <button class="btn btn-primary w-100">حفظ الملاحظة</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal تأكيد الإلغاء -->
    <div class="modal fade" id="cancelModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تأكيد إلغاء الطلب</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>هل أنت متأكد من رغبتك في إلغاء هذا الطلب؟</p>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        لا يمكن التراجع عن هذا الإجراء بعد التأكيد.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">تراجع</button>
                    <button type="button" class="btn btn-danger">تأكيد الإلغاء</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function confirmCancel() {
            var cancelModal = new bootstrap.Modal(document.getElementById('cancelModal'));
            cancelModal.show();
        }
    </script>
@endpush
