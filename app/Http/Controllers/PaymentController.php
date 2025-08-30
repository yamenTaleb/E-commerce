<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Product;
use App\Services\CartService;
use App\Services\CouponService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Coupon;
use Stripe\Stripe;
use App\Services\StripeWebhookService;

class PaymentController extends Controller
{
    protected $stripeWebhookService;

    public function __construct(
        StripeWebhookService $stripeWebhookService,
        public CartService $cartService,
        public OrderService $orderService,
        public CouponService $couponService
    )
    {
        $this->stripeWebhookService = $stripeWebhookService;
    }

    public function checkout(StoreOrderRequest $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $cartItems = CartService::cartItems();

        $lineItems = [];

        foreach ($cartItems as $item) {
            $unit_price = $item->product->price - $item->product->price * $item->product->discount / 100;

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item->product->name,
                    ],
                    'unit_amount' => $unit_price * 100,
                ],
                'quantity' => $item->quantity,
            ];
        }

        if($request->coupon)
        $coupon = Coupon::create([
            'amount_off' => $this->couponService->discount($request['coupon']) * 100,
            'currency' => 'eur',
        ]);

        $session = Session::create([
            'line_items' => $lineItems,
            'discounts' => [[
                'coupon' => $coupon->id ?? null,
            ]],
            'mode' => 'payment',
            'payment_method_types' => ['card'],
            'success_url' => route('payments.success', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('payments.cancel', [], true),
        ]);

        $request->merge([
            'session_id' => $session->id,
        ]);

        $order = $this->orderService->store($request);

        $this->orderService->storeOrderDetails($order);

        $this->cartService->flush();

        return ApiResponse::sendResponse(200, 'redirect page', ['url' => $session->url]);
    }

    public function success(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = \Stripe\Checkout\Session::retrieve($request->session_id);

        if ($session->payment_status === 'paid') {
            $order = Order::query()
                ->where('session_id', $request->session_id)->first();

            $this->orderService->update('paid', $order);

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
