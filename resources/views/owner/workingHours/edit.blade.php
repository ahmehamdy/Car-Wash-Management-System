@extends('layouts.dashboard')

@section('title', 'تعديل مواعيد العمل')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h4 mb-2 text-gray-800">
                    <i class="fas fa-edit fa-fw"></i> تعديل مواعيد {{ $arabicDays[$workingHour->day] }}
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('car-wash-working-hours.index', $carWash) }}">
                                <i class="fas fa-clock fa-fw"></i> مواعيد العمل
                            </a>
                        </li>
                        <li class="breadcrumb-item active">تعديل {{ $arabicDays[$workingHour->day] }}</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('car-wash-working-hours.index', $carWash) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-right fa-fw"></i> العودة للقائمة
            </a>
        </div>

        <!-- إشعار إذا كان اليوم إجازة -->
        @php
            $isDayOff = !$workingHour->open_time && !$workingHour->close_time;
        @endphp

        @if ($isDayOff)
            <div class="alert alert-warning mb-4">
                <i class="fas fa-info-circle fa-fw"></i>
                <strong>هذا يوم إجازة:</strong> لم يتم تحديد مواعيد عمل لهذا اليوم.
                <br>
                <small>لتحويله إلى يوم عمل، حدد وقت الفتح والإغلاق أدناه.</small>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold {{ $isDayOff ? 'text-danger' : 'text-primary' }}">
                            <i class="fas fa-calendar-day fa-fw"></i>
                            {{ $arabicDays[$workingHour->day] }}
                            @if ($isDayOff)
                                <span class="badge badge-danger ml-2">إجازة</span>
                            @else
                                <span class="badge badge-success ml-2">يوم عمل</span>
                            @endif
                        </h6>
                        <div class="badge badge-light">
                            <i class="fas fa-calendar fa-fw"></i>
                            {{ now()->format('Y-m-d') }}
                        </div>
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ route('car-wash-working-hours.update', ['carWash' => $carWash, 'workingHour' => $workingHour]) }}"
                            method="POST" id="editForm">
                            @csrf
                            @method('PUT')

                            <div class="alert alert-info mb-4">
                                <i class="fas fa-lightbulb fa-fw"></i>
                                <strong>ملاحظة:</strong>
                                اترك الحقول فارغة إذا كنت تريد جعل هذا اليوم إجازة.
                            </div>

                            <div class="form-group">
                                <label for="open_time" class="form-label font-weight-bold">
                                    <i class="fas fa-door-open fa-fw text-success"></i>
                                    وقت بداية العمل
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-sun text-warning"></i>
                                        </span>
                                    </div>
                                    <input type="time" class="form-control @error('open_time') is-invalid @enderror"
                                        id="open_time" name="open_time" value="{{ old('open_time') }}">
                                </div>
                                @error('open_time')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    اتركه فارغاً إذا كان اليوم إجازة
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="close_time" class="form-label font-weight-bold">
                                    <i class="fas fa-door-closed fa-fw text-danger"></i>
                                    وقت نهاية العمل
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-moon text-info"></i>
                                        </span>
                                    </div>
                                    <input type="time" class="form-control @error('close_time') is-invalid @enderror"
                                        id="close_time" name="close_time" value="{{ old('close_time') }}">
                                </div>
                                @error('close_time')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    اتركه فارغاً إذا كان اليوم إجازة
                                </small>
                            </div>

                            <div class="p-3 border rounded bg-light mb-4">
                                <div class="text-center">
                                    @if ($workingHour->open_time && $workingHour->close_time)
                                        @php
                                            $open = \Carbon\Carbon::parse($workingHour->open_time);
                                            $close = \Carbon\Carbon::parse($workingHour->close_time);
                                            $totalMinutes = $open->diffInMinutes($close);

                                            $hours = intdiv($totalMinutes, 60);
                                            $minutes = $totalMinutes % 60;

                                            if ($hours == 0) {
                                                $durationText = "{$minutes} دقيقة";
                                            } elseif ($minutes == 0) {
                                                $durationText = "{$hours} ساعة";
                                            } else {
                                                $durationText = "{$hours} ساعة و {$minutes} دقيقة";
                                            }
                                        @endphp

                                        <i class="fas fa-business-time fa-2x text-success mb-2"></i>
                                        <h5 class="mb-1 text-success">يوم عمل</h5>
                                        <div class="display-4 text-success font-weight-bold">
                                            {{ $durationText }}
                                        </div>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($workingHour->open_time)->format('h:i A') }} -
                                            {{ \Carbon\Carbon::parse($workingHour->close_time)->format('h:i A') }}
                                        </small>
                                    @else
                                        <i class="fas fa-umbrella-beach fa-2x text-danger mb-2"></i>
                                        <h5 class="mb-1 text-danger">يوم إجازة</h5>
                                        <div class="display-4 text-danger font-weight-bold">
                                            إجازة
                                        </div>
                                        <small class="text-muted">
                                            لا يوجد عمل في هذا اليوم
                                        </small>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                <a href="{{ route('car-wash-working-hours.index', $carWash) }}"
                                    class="btn btn-outline-secondary">
                                    <i class="fas fa-times fa-fw"></i> إلغاء
                                </a>
                                <div>
                                    <button type="button" class="btn btn-outline-danger mr-2" id="setDayOffBtn">
                                        <i class="fas fa-ban fa-fw"></i> تعيين إجازة
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save fa-fw"></i> حفظ التغييرات
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card shadow mt-4">
                    <div class="card-body">
                        <h6 class="font-weight-bold text-primary mb-3">
                            <i class="fas fa-calendar-check fa-fw"></i> معلومات اليوم
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <strong><i class="fas fa-calendar-alt fa-fw text-primary"></i> اليوم:</strong>
                                    <span class="float-left">{{ $arabicDays[$workingHour->day] }}</span>
                                </div>
                                <div class="mb-3">
                                    <strong><i class="fas fa-clock fa-fw text-success"></i> وقت الفتح الحالي:</strong>
                                    <span class="float-left">
                                        @if ($workingHour->open_time)
                                            {{ \Carbon\Carbon::parse($workingHour->open_time)->format('h:i A') }}
                                        @else
                                            <span class="text-danger">إجازة</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <strong><i class="fas fa-calendar fa-fw text-primary"></i> اليوم بالإنجليزية:</strong>
                                    <span class="float-left text-muted">{{ $workingHour->day }}</span>
                                </div>
                                <div class="mb-3">
                                    <strong><i class="fas fa-clock fa-fw text-danger"></i> وقت الإغلاق الحالي:</strong>
                                    <span class="float-left">
                                        @if ($workingHour->close_time)
                                            {{ \Carbon\Carbon::parse($workingHour->close_time)->format('h:i A') }}
                                        @else
                                            <span class="text-danger">إجازة</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const openTimeInput = document.getElementById('open_time');
                const closeTimeInput = document.getElementById('close_time');
                const setDayOffBtn = document.getElementById('setDayOffBtn');
                const form = document.getElementById('editForm');

                setDayOffBtn.addEventListener('click', function() {
                    if (confirm('هل تريد جعل هذا اليوم إجازة؟ سيتم مسح جميع مواعيد العمل.')) {
                        openTimeInput.value = '';
                        closeTimeInput.value = '';
                        form.submit();
                    }
                });

                form.addEventListener('submit', function(e) {
                    const openTime = openTimeInput.value;
                    const closeTime = closeTimeInput.value;

                    if ((openTime && !closeTime) || (!openTime && closeTime)) {
                        e.preventDefault();
                        alert('يرجى ملء كلتا الحقلين أو تركها فارغة لجعل اليوم إجازة');
                        return;
                    }

                    if (openTime && closeTime) {
                        if (openTime >= closeTime) {
                            e.preventDefault();
                            alert('وقت الإغلاق يجب أن يكون بعد وقت الفتح');
                            openTimeInput.focus();
                            return;
                        }
                    }

                });
            });
        </script>
    @endpush

    <style>
        .input-group-text {
            background-color: #f8f9fc;
            border-color: #d1d3e2;
        }

        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .card-header {
            border-bottom: 1px solid #e3e6f0;
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }

        .badge-success {
            background-color: #1cc88a;
            color: white;
        }

        .badge-danger {
            background-color: #e74a3b;
            color: white;
        }
    </style>
@endsection
