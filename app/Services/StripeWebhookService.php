<?php

namespace App\Services;

use App\Models\Order;

class StripeWebhookService
{
    public function handleCheckoutSessionCompleted($session)
    {
        $order = Order::query()
            ->where('session_id', $session->id)->first();
        if ($order && $order->status === 'unpaid') {
            $order->status = 'paid';
            $order->save();
            // Send email to customer
            // You can add more logic here, like updating inventory, sending notifications, etc.
        }
    }
}
