<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewOrderForCarWash;
use App\Mail\OrderConfirmedForUser;

class OrderMailService
{
    public function sendNewOrderMail(Order $order)
    {
        Mail::to($order->carWash->user->email)->queue(new NewOrderForCarWash($order));
    }
    public function sendConfimedOrderMail(Order $order)
    {
        Mail::to($order->user->email)->queue(new OrderConfirmedForUser($order));
    }
}
