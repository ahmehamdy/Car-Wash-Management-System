<?php

namespace App\Actions\Order;

use App\Models\CarWash;
use App\Models\Order;
use App\Models\User;
use App\Services\OrderMailService;
use App\Services\OrderService;
use App\Services\PickupValidationService;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class UpdateOrderAction
{
    public function __construct(
        private PickupValidationService $validation,
        private OrderService $orderService,
        private OrderMailService $miler
    ) {}

    public function execute(Order $order, array $data, User $user)
    {
        $carWash = CarWash::where('id', $order->car_wash_id)->firstOrFail();
        $pickup = Carbon::createFromFormat('Y-m-d H:i', $data['pickup_time']);
        $this->validation->validate($carWash, $user, $pickup);
        $order->update([
            'pickup_time' => $data['pickup_time']
        ]);

        if (!empty($data['services'])) {
            $order = $this->orderService->attachService($order, $data['services']);
        }
        $this->miler->sendNewOrderMail($order);

        return $order;
    }
}
