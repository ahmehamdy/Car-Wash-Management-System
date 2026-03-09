@extends('layouts.dashboard')

@section('title', 'جميع الطلبات')
@section('page-title', 'إدارة الطلبات')

@section('content')
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex gap-2">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary active">الكل</button>
                    <button type="button" class="btn btn-outline-warning">قيد الانتظار</button>
                    <button type="button" class="btn btn-outline-info">قيد التنفيذ</button>
                    <button type="button" class="btn btn-outline-success">مكتملة</button>
                    <button type="button" class="btn btn-outline-danger">ملغية</button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="بحث عن طلب...">
                <button class="btn btn-primary" type="button">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">جميع الطلبات (24)</h5>
                        </div>
                        <div class="col-auto">
                            <select class="form-select form-select-sm">
                                <option>ترتيب حسب: الأحدث</option>
                                <option>ترتيب حسب: الأقدم</option>
                                <option>ترتيب حسب: الأعلى سعراً</option>
                                <option>ترتيب حسب: الأقل سعراً</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>رقم الطلب</th>
                                    <th>المغسلة</th>
                                    <th>الخدمة</th>
                                    <th>التاريخ</th>
                                    <th>المبلغ</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 1; $i <= 10; $i++)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td><span class="fw-bold">#ORD-2024-00{{ $i }}</span></td>
                                        <td>مغسلة النور للسيارات</td>
                                        <td>غسيل خارجي + تلميع</td>
                                        <td>2024-02-{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</td>
                                        <td>150 ج.م</td>
                                        <td>
                                            @php
                                                $statuses = [
                                                    1 => ['قيد الانتظار', 'warning'],
                                                    2 => ['قيد التنفيذ', 'info'],
                                                    3 => ['مكتملة', 'success'],
                                                    4 => ['ملغية', 'danger'],
                                                ];
                                                $random = rand(1, 4);
                                            @endphp
                                            <span class="badge bg-{{ $statuses[$random][1] }}">
                                                {{ $statuses[$random][0] }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('orders.show', $i) }}" class="btn btn-sm btn-info"
                                                title="عرض">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @if ($random == 1)
                                                <a href="{{ route('orders.edit', $i) }}" class="btn btn-sm btn-warning"
                                                    title="تعديل">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            @endif
                                            @if ($random == 4)
                                                <button class="btn btn-sm btn-secondary" disabled>
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>

                    <nav class="mt-4">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link" href="#">5</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
