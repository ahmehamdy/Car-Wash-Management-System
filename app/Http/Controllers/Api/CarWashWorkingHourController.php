<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarWash;
use App\Services\CarWashWorkingHourService;
use Illuminate\Http\Request;

class CarWashWorkingHourController extends Controller
{
    public function store(Request $request, CarWash $carWash, CarWashWorkingHourService $carWashWorkingHourService)
    {
        if (!auth()->user() == $carWash->user_id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }
        $request->validate([
            'days' => 'required|array|min:1',
            'days.*' => 'in:saturday,sunday,monday,tuesday,wednesday,thursday,friday',
            'open_time' => 'required|date_format:H:i',
            'close_time' => 'required|date_format:H:i|after:open_time'

        ]);

        $carWashWorkingHourService->addWorkingHours($carWash, $request->days, $request->open_time, $request->close_time);

        return response()->json([
            'message'=>'your working hours added'
        ],201);
    }
}
