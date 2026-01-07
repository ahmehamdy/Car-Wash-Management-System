<?php

namespace App\Actions\Order;

use App\Models\Order;
use App\Services\OrderMailService;
use App\Services\OrderService;

class UpdateStatusAction
{
    public function __construct(
        private OrderService $updatestatus,
        private OrderMailService $miler
    ) {}
    public function execute(Order $order, string $newStatus)
    {
        $order = $this->updatestatus->updateOrderStatus($order,$newStatus);
        $this->miler->sendConfimedOrderMail($order);
        return $order->refresh();
    }
}
