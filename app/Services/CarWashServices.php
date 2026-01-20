<?php

namespace App\Services;

use App\Models\CarWash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CarWashServices
{
    public function craeteCarWash($request)
    {
        $images = [];

        if ($request->hasFile('images')) {
            foreach ($request['images'] as $image) {
                $images[] = $image->store('car_wash_images', 'public');
            }
        }

        $carWash = CarWash::create([
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'phone' => $request->phone,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'images' => $images,
            'user_id' => Auth::id()
        ]);

        return $carWash;
    }

    public function updateCarWash($request, $carWash)
    {
        $images = $carWash->images ?? [];

        if ($request->filled('deleted_images')) {
            $deletedImages = json_decode($request->deleted_images, true);

            $images = array_values(array_diff($images, $deletedImages));

            foreach ($deletedImages as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('car_wash_images', 'public');
            }
        }

        $carWash->update([
            'name'=> $request->name,
            'description' => $request->description,
            'address'=> $request->address,
            'phone'=> $request->phone,
            'lat'=> $request->lat,
            'lng'=> $request->lng,
            'images'=> $images,
        ]);

        return $carWash;
    }
}
