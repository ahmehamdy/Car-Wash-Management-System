<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarWash;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewOrderForCarWash;

class OrderController extends Controller
{
    public function store(Request $request, OrderService $orderService, CarWash $carWash)
    {
        $valideted = $request->validate([
            'services' => 'required|array|min:1',
            'services.*.id' => 'required|exists:services,id',
            'services.*.qty' => 'sometimes|integer|min:1',
            'pickup_time' => 'required|date_format:Y-m-d H:i'
        ]);

        $order = $orderService->createOrder(auth()->user(), $valideted['pickup_time'], $carWash, $valideted['services']);

        return response()->json([
            'message' => 'order added',
            'order' => $order->load('services')
        ], 201);
    }

    public function showMyOrder(Order $order)
    {
        return response()->json([
            'message' => 'your order',
            'order' => $order
        ], 200);
    }

    public function updateMyOrder(Request $request, Order $order, OrderService $orderService)
    {

        $valideted = $request->validate([
            'pickup_time' => 'sometimes|date_format:Y-m-d H:i',
            'services' => 'sometimes|array|min:1',
            'services.*.id' => 'sometimes|exists:services,id',
            'services.*.qty' => 'sometimes|integer|min:1',
        ]);

        if ($order->status !== 'pending') {
            return response()->json([
                'message' => 'order cannot be updated'
            ], 403);
        }

        $order = $orderService->updateMyOrder($order, $valideted['services'] ?? [], $valideted['pickup_time'] ?? null);

        return response()->json([
            'message' => 'order updated',
            'order' => $order->load('services')
        ], 200);
    }

    public function showCarwashOrder(CarWash $carWash)
    {

        $order = $carWash->orders()->latest()->get();

        return response()->json([
            'message' => 'your orders',
            'order' => $order
        ], 200);
    }

    public function updateStatus(Request $request, $orderId, OrderService $orderService)
    {
        $validate = $request->validate([
            'status' => 'required|in:confirmed,cancelled,completed'
        ]);
        $order = Order::wherekey($orderId)->wherehas('carWash', function ($q) {
            $q->where('user_id', auth()->id());
        })->firstOrFail();

        $order = $orderService->updateStatus($order, $validate['status']);

        return response()->json([
            'message' => 'order status updated ',
            'order' => $order
        ]);
    }

    public function deleteMyOrder(Order $order)
    {
        $order->delete();
        return response()->json([
            'message' => 'order deleted'
        ], 200);
    }
}
