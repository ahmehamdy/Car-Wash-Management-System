<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function addRating(Request $request,$orderId){

        $validated = $request->validate([
            'stars'=>'required|integer|min:1|max:5',
            'comment'=>'nullable|string|max:500'
        ]);
        $order = auth()->user()->orders()->wherekey($orderId)->firstOrFail();
        if($order->rating){
            return response()->json([
                'message'=>'you already rated this order'
            ],403);
        }

        $rating = $order->rating()->create($validated);
        return response()->json([
            'message'=>'rating added',
            "rating"=>$rating->load('order')
        ],201);
    }
}
