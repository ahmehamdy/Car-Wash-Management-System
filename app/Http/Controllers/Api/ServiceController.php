<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarWash;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function store(Request $request, CarWash $carwash)
    {

        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0|max:100'
        ]);

        $service = $carwash->services()->create($validate);

        return response()->json([
            'message' => 'service added',
            'service' => $service
        ], 201);
    }

    public function update(Request $request, Service $service)
    {

        $validate = $request->validate([
            'name' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|min:0|max:100'
        ]);

        $service->update($validate);

        return response()->json([
            'message' => 'service updated',
            'service' => $service
        ], 200);
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return response()->json([
            'message' => 'service deleted',
        ], 200);
    }
}
