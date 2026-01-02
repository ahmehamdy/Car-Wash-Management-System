<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarWash;

class CarWashController extends Controller
{
    public function store(Request $request)
    {

        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',

        ]);

        $carWash = auth()->user()->carWashes()->create($validate);
        return response()->json([
            'message' => 'Car Wash Created',
            'car_wash' => $carWash,
        ], 201);
    }

    public function show($id)
    {

        $carWash = auth()->user()->carWashes()->findOrFail($id);

        return response()->json([
            'car_wash' => $carWash->load('workingHours')
        ], 200);
    }

    public function update(Request $request, $id)
    {

        $validate = $request->validate([
            'name' => 'sometimes|string|max:255',
            'address' => 'sometimes|string',
            'lat' => 'sometimes|numeric|between:-90,90',
            'lng' => 'sometimes|numeric|between:-180,180',

        ]);

        $carWash = auth()->user()->carWashes()->findOrFail($id);

        $carWash->update($validate);

        return response()->json([
            'car_wash' => $carWash
        ], 200);
    }

    public function destroy($id)
    {
        $carWash = auth()->user()->carWashes()->findOrFail($id);
        $carWash->delete();
        return response()->json([
            'message' => 'Car Wash deleted successfully'
        ], 200);
    }
}
