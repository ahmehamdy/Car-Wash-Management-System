<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\CarWash;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class OrderController extends Controller
{
    use AuthorizesRequests;

    public function store(StoreOrderRequest $request, OrderService $orderService, CarWash $carWash)
    {
        $this->authorize('create');
        $valideted = $request->validated();

        $order = $orderService->createOrder(auth()->user(), $valideted['pickup_time'], $carWash, $valideted['services']);

        return response()->json([
            'message' => 'order added',
            'order' => $order->load('services')
        ], 201);
    }

    public function showMyOrder(Order $order)
    {
        $this->authorize('viewMyOrder', $order);
        return response()->json([
            'message' => 'your order',
            'order' => $order
        ], 200);
    }

    public function updateMyOrder(UpdateOrderRequest $request, Order $order, OrderService $orderService)
    {
        $valideted = $request->validated();

        $order = $orderService->updateMyOrder($order, $valideted['services'] ?? [], $valideted['pickup_time'] ?? null);

        return response()->json([
            'message' => 'order updated',
            'order' => $order->load('services')
        ], 200);
    }

    public function showCarwashOrder(CarWash $carWash)
    {
        $this->authorize('viewCarWashOrder',$carWash);
        $order = $carWash->orders()->latest()->get();

        return response()->json([
            'message' => 'your orders',
            'order' => $order
        ], 200);
    }

    public function updateStatus(UpdateStatusRequest $request, Order $order, OrderService $orderService)
    {
        $validate = $request->validated();

        $order = $orderService->updateStatus($order, $validate['status']);

        return response()->json([
            'message' => 'order status updated ',
            'order' => $order
        ]);
    }

    public function deleteMyOrder(Order $order)
    {
        $this->authorize('delete',$order);
        $order->delete();
        return response()->json([
            'message' => 'order deleted'
        ], 200);
    }
}
