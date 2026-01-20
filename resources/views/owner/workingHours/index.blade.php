@extends('layouts.dashboard')

@section('title', 'مواعيد العمل')

@section('content')
    <div class="container-fluid py-4">
        <!-- رأس الصفحة -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h4 mb-2 text-gray-800">
                    <i class="fas fa-clock fa-fw"></i> مواعيد عمل الكارووش
                </h1>
                <p class="text-muted mb-0">إدارة أوقات العمل الأسبوعية</p>
            </div>
            <div>
                <a href="{{ route('carwashes.index') }}" class="btn btn-outline-info ms-2">
                    <i class="bi bi-arrow-right"></i> المغاسل
                </a>
            </div>
        </div>

        <!-- رسائل النجاح -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle fa-fw"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle fa-fw"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        <!-- جدول المواعيد -->
        <div class="card shadow">
            <div class="card-header bg-primary text-white py-3">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-calendar-week fa-fw"></i> الجدول الأسبوعي
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="bg-light text-center">
                            <tr>
                                <th width="20%">اليوم</th>
                                <th width="20%">وقت الفتح</th>
                                <th width="20%">وقت الإغلاق</th>
                                <th width="20%">مدة العمل</th>
                                <th width="20%">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($workingHours as $hour)
                                @php
                                    $openTime = $hour->open_time ? \Carbon\Carbon::parse($hour->open_time) : null;
                                    $closeTime = $hour->close_time ? \Carbon\Carbon::parse($hour->close_time) : null;

                                    // تحديد إذا كان اليوم إجازة
                                    $isDayOff = !$openTime && !$closeTime;

                                    if (!$isDayOff && $openTime && $closeTime) {
                                        $duration = $closeTime->diff($openTime);
                                        $hours = $duration->h;
                                        $minutes = $duration->i;

                                        if ($hours == 0) {
                                            $durationText = "{$minutes} دقيقة";
                                        } elseif ($minutes == 0) {
                                            $durationText = "{$hours} ساعة";
                                        } else {
                                            $durationText = "{$hours} ساعة {$minutes} دقيقة";
                                        }
                                    } else {
                                        $durationText = 'إجازة';
                                    }
                                @endphp
                                <tr>
                                    <td class="font-weight-bold">
                                        <i
                                            class="fas fa-calendar-day fa-fw {{ $isDayOff ? 'text-danger' : 'text-primary' }}"></i>
                                        {{ $arabicDays[$hour->day] }}
                                        @if ($isDayOff)
                                            <span class="badge badge-danger badge-pill ml-2">إجازة</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            @if (!$isDayOff && $hour->open_time)
                                                <span
                                                    class="badge {{ $isDayOff ? 'badge-secondary' : 'badge-success' }} p-2 text-dark">
                                                    {{ \Carbon\Carbon::parse($hour->open_time)->format('h:i A') }}
                                                </span>
                                            @else
                                                <span class="badge badge-secondary p-2 text-dark">
                                                    {{ $isDayOff ? 'إجازة' : 'غير محدد' }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            @if (!$isDayOff && $hour->close_time)
                                                <span
                                                    class="badge {{ $isDayOff ? 'badge-secondary' : 'badge-danger' }} p-2 text-dark">
                                                    {{ \Carbon\Carbon::parse($hour->close_time)->format('h:i A') }}
                                                </span>
                                            @else
                                                <span class="badge badge-secondary p-2 text-dark">
                                                    {{ $isDayOff ? 'إجازة' : 'غير محدد' }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <span class="badge {{ $isDayOff ? 'bg-danger' : 'bg-info' }} p-2">
                                                <i class="fas fa-business-time fa-fw"></i>
                                                {{ $durationText }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('car-wash-working-hours.edit', ['carWash' => $carWash, 'workingHour' => $hour]) }}"
                                            class="btn btn-sm {{ $isDayOff ? 'btn-danger' : 'btn-primary' }}">
                                            <i class="fas fa-edit fa-fw"></i> {{ $isDayOff ? 'تعديل الإجازة' : 'تعديل' }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
