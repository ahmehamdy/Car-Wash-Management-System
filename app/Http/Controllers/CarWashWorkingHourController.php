<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorkingHoursRequest;
use App\Models\CarWash;
use App\Models\CarWashWorkingHour;
use App\Services\CarWashWorkingHourService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class CarWashWorkingHourController extends Controller
{
    use AuthorizesRequests;
    // public function index(CarWash $carWash)
    // {
    //     $workingHours = $carWash->workingHours()->get();
    //     return view('workingHours.index', compact('workingHours', 'carWash'));
    // }
    public function index(CarWash $carWash)
    {
        // الحصول على مواعيد العمل
        $workingHours = $carWash->workingHours()
            ->orderByRaw("FIELD(day, 'saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday')")
            ->get();

        // إنشاء أيام مفقودة إذا لزم الأمر
        $days = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'];

        $arabicDays = [
            'saturday' => 'السبت',
            'sunday' => 'الأحد',
            'monday' => 'الإثنين',
            'tuesday' => 'الثلاثاء',
            'wednesday' => 'الأربعاء',
            'thursday' => 'الخميس',
            'friday' => 'الجمعة'
        ];

        foreach ($days as $day) {
            $existing = $workingHours->where('day', $day)->first();
            if (!$existing) {
                CarWashWorkingHour::create([
                    'car_wash_id' => $carWash->id,
                    'day' => $day,
                    'open_time' => '08:00',
                    'close_time' => '17:00'
                ]);
            }
        }

        // إعادة تحميل البيانات
        $workingHours = CarWashWorkingHour::where('car_wash_id', $carWash->id)
            ->orderByRaw("FIELD(day, 'saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday')")
            ->get();

        return view('owner.workingHours.index', compact('workingHours', 'carWash', 'arabicDays'));
    }

    public function store(StoreWorkingHoursRequest $request, CarWash $carWash, CarWashWorkingHourService $carWashWorkingHourService)
    {
        $request->validated();

        $carWashWorkingHourService->addWorkingHours($carWash, $request->days, $request->open_time, $request->close_time);

        return redirect()->back()->with('success', 'Time Added succssfully');
    }

    public function edit(CarWash $carWash, CarWashWorkingHour $workingHour)
    {
        $this->authorize('update', $workingHour);

        $arabicDays = [
            'saturday' => 'السبت',
            'sunday' => 'الأحد',
            'monday' => 'الإثنين',
            'tuesday' => 'الثلاثاء',
            'wednesday' => 'الأربعاء',
            'thursday' => 'الخميس',
            'friday' => 'الجمعة'
        ];

        return view('owner.workingHours.edit', compact('workingHour', 'arabicDays', 'carWash'));
    }

    public function update(Request $request, CarWash $carWash, CarWashWorkingHour $workingHour)
    {
        $this->authorize('update', $workingHour);

        if (empty($request->input('open_time')) && empty($request->input('close_time'))) {
            $workingHour->update([
                'open_time' => null,
                'close_time' => null
            ]);

            return redirect()->route('car-wash-working-hours.index', $carWash)
                ->with('success', 'تم تحديد اليوم كيوم إجازة بنجاح');
        }

        $validated = $request->validate([
            'open_time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $value)) {
                        $fail('تنسيق وقت الفتح غير صحيح. استخدم الصيغة ساعة:دقيقة (مثال: 08:30)');
                    }
                },
            ],
            'close_time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {
                    if (!preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $value)) {
                        $fail('تنسيق وقت الإغلاق غير صحيح. استخدم الصيغة ساعة:دقيقة (مثال: 17:00)');
                        return;
                    }

                    $openTime = $request->input('open_time');
                    if ($openTime && $value && strtotime($value) <= strtotime($openTime)) {
                        $fail('وقت الإغلاق يجب أن يكون بعد وقت الفتح');
                    }
                },
            ],
        ], [
            'open_time.required' => 'حقل وقت الفتح مطلوب',
            'open_time.date_format' => 'تنسيق وقت الفتح يجب أن يكون ساعة:دقيقة (مثال: 08:00)',
            'close_time.required' => 'حقل وقت الإغلاق مطلوب',
            'close_time.date_format' => 'تنسيق وقت الإغلاق يجب أن يكون ساعة:دقيقة (مثال: 17:00)',
        ]);

        $workingHour->update($validated);

        return redirect()->route('car-wash-working-hours.index', $carWash)
            ->with('success', 'تم تحديث مواعيد العمل بنجاح');
    }
}
