<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorkingHoursRequest;
use App\Models\CarWash;
use App\Services\CarWashWorkingHourService;
use Illuminate\Http\Request;

class CarWashWorkingHourController extends Controller
{
    public function store(StoreWorkingHoursRequest $request, CarWash $carWash, CarWashWorkingHourService $carWashWorkingHourService)
    {
        $request->validated();

        $carWashWorkingHourService->addWorkingHours($carWash, $request->days, $request->open_time, $request->close_time);

        return response()->json([
            'message'=>'your working hours added'
        ],201);
    }
}
