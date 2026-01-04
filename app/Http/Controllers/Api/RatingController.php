<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRatingRequest;
use App\Models\Order;

class RatingController extends Controller
{
    public function addRating(StoreRatingRequest $request, Order $order){

        $validated = $request->validated();
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
