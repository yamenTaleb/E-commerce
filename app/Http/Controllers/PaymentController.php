<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Order;
use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Support\Facades\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use App\Services\StripeWebhookService;

class PaymentController extends Controller
{
    protected $stripeWebhookService;

    public function __construct(StripeWebhookService $stripeWebhookService)
    {
        $this->stripeWebhookService = $stripeWebhookService;
    }

    public function checkout(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $cartItems = CartService::cartItems();

        $lineItems = [];
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item->price;
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item->product->name,
                    ],
                    'unit_amount' =>  (int) $item->product->price,
                ],
                'quantity' => $item->quantity,
            ];
        }

        $session = Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'payment_method_types' => ['card'], // Add this line
            'success_url' => route('payments.success', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('payments.cancel', [], true),
        ]);

        $order = new Order();
        $order->status = 'unpaid';
        $order->user_id = auth()->user()->id ?? 2;
        $order->session_id = $session->id;
        $order->order_date = now();
        $order->save();

        return ApiResponse::sendResponse(302, 'redirect page', ['url' => $session->url]);
    }

    public function success(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = \Stripe\Checkout\Session::retrieve($request->session_id);

        if ($session->payment_status ==='paid') {
            $order = Order::query()
                ->where('session_id', $request->session_id)->first();
            $order->status = 'paid';
            $order->save();

//            till front end work
//            $cartItems = CartService::cartItems();
//            foreach ($cartItems as $item) {
//                $product = Product::findOrFail($item->product_id);
//                $product->stock_quantity -= $item->quantity;
//                $product->save();
//            }
//            Cart::query()
//                ->where('user_id', Auth::user()->id)->delete();

            return ApiResponse::sendResponse(200, 'Payment successful');
        } else {
            return ApiResponse::sendResponse(400, 'Payment failed');
        }
    }

    public function cancel()
    {
        // till front end work
//        $order = Order::where('user_id', Auth::id())
//                      ->where('status', 'unpaid')
//                      ->latest()
//                      ->first();
//
//        if ($order) {
//            $order->status = 'cancelled';
//            $order->save();
//        }

        return ApiResponse::sendResponse(200, 'Payment cancelled');
    }

    public function webhook(Request $request)
    {
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            return response('', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response('', 400);
        }

        // Handle the event
        match ($event->type) {
            'checkout.session.completed' => $this->stripeWebhookService->handleCheckoutSessionCompleted($event->data->object),
            default => "Received unknown event type {$event->type}",
        };

        return response('OK', 200);
    }
}
