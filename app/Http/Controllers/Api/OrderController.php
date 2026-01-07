<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\CarWash;
use App\Models\Order;
use App\Actions\Order\CreateOrderAction;
use App\Actions\Order\UpdateOrderAction;
use App\Actions\Order\UpdateStatusAction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class OrderController extends Controller
{
    public function __construct(
        private CreateOrderAction $createAction,
        private UpdateOrderAction $updateAction,
        private UpdateStatusAction $updateStatus
    ) {}
    use AuthorizesRequests;

    public function store(StoreOrderRequest $request, CarWash $carWash)
    {
        // $this->authorize('create');
        $data = $request->validated();

        $order = $this->createAction->execute(auth()->user(), $carWash, $data);

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

    public function listMyOrders()
    {
        $orders = auth()->user()->orders()->get();
        return response()->json([
            'message' => 'your orders',
            'orders' => $orders
        ], 200);
    }

    public function updateMyOrder(UpdateOrderRequest $request, Order $order)
    {
        $data = $request->validated();

        $order = $this->updateAction->execute($order, $data, auth()->user());

        return response()->json([
            'message' => 'order updated',
            'order' => $order->load('services')
        ], 200);
    }

    public function showCarwashOrder(CarWash $carWash)
    {
        // $this->authorize('viewCarWashOrder', $carWash);
        $order = $carWash->orders()->latest()->get();

        return response()->json([
            'message' => 'your orders',
            'order' => $order
        ], 200);
    }

    public function updateStatus(UpdateStatusRequest $request, Order $order)
    {
        $data = $request->validated();
        $order = $this->updateStatus->execute($order, $data['status']);
        return response()->json([
            'message' => 'order status updated ',
            'order' => $order
        ]);
    }

    public function deleteMyOrder(Order $order)
    {
        $this->authorize('delete', $order);
        $order->delete();
        return response()->json([
            'message' => 'order deleted'
        ], 200);
    }
}
