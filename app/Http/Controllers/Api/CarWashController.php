<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarWashRequest;
use App\Http\Requests\UpdateCarWashRequest;
use Illuminate\Http\Request;
use App\Models\CarWash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CarWashController extends Controller
{
    use AuthorizesRequests;
    public function store(StoreCarWashRequest $request)
    {
        $validated = $request->validated();

        $carWash = auth()->user()->carWashes()->create($validated);
        return response()->json([
            'message' => 'Car Wash Created',
            'car_wash' => $carWash,
        ], 201);
    }

    public function show(CarWash $carWash)
    {
        $this->authorize('view', $carWash);
        return response()->json([
            'car_wash' => $carWash->load('workingHours')
        ], 200);
    }

    public function update(UpdateCarWashRequest $request, CarWash $carWash)
    {
        $validated = $request->validated();
        $carWash->update($validated);

        return response()->json([
            'car_wash' => $carWash
        ], 200);
    }

    public function destroy(CarWash $carWash)
    {
        $this->authorize('delete', $carWash);
        $carWash->delete();
        return response()->json([
            'message' => 'Car Wash deleted successfully'
        ], 200);
    }
}
