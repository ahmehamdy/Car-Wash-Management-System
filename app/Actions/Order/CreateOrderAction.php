<?php

namespace App\Actions\Order;

use App\Models\CarWash;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Services\OrderMailService;
use App\Services\OrderService;
use App\Services\PickupValidationService;

class CreateOrderAction
{
    public function __construct(
        private PickupValidationService $validation,
        private OrderService $orderService,
        private OrderMailService $mailer
    ) {}

    public function execute(User $user, CarWash $carWash, array $data)
    {
        $pickup = Carbon::parse($data['pickup_time']);
        // dd('before validation');
        // $this->validation->validate($carWash, $user, $pickup);

        $order = $this->orderService->createOrder($user, $carWash, $pickup);
        $order = $this->orderService->attachService($order, $data['services']);
        $this->mailer->sendNewOrderMail($order);
        return $order->refresh();
    }
}
