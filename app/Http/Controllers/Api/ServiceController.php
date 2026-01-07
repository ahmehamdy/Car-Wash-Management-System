<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\CarWash;
use App\Models\Service;

class ServiceController extends Controller
{
    public function store(StoreServiceRequest $request, CarWash $carwash)
    {
        $validate = $request->validated();

        $service = $carwash->services()->create($validate);

        return response()->json([
            'message' => 'service added',
            'service' => $service
        ], 201);
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        $validate = $request->validated();

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
