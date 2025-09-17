<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Resources\Payment;

class PaymentController extends Controller
{
    public function __construct()
    {
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));
    }

    /**
     * Create a payment preference and redirect to checkout
     */
    public function create(Order $order)
    {
        // Remove items already purchased by the user
        foreach ($order->items as $item) {
            if (auth()->user()->hasBought($item->asset)) {
                $item->delete();
            }
        }
        $order->load('items');
        $order->total = $order->items->sum(fn($item) => $item->price);
        $order->save();

        // If no items left, cancel the order
        if ($order->items->count() === 0) {
            $order->update(['status' => 'cancelled']);
            session()->flash('message', "You already has all the items from this order. Order cancelled.");
            return redirect()->route('myOrders');
        }

        $title = '';

        foreach ($order->items as $item) {
            $title .= $item->asset->title . ', ';
        }

        $title = rtrim($title, ', ');

        $user = auth()->user();

        try {
            $client = new PreferenceClient();

            // Create preference with order details
            $preference = $client->create([
                "items" => [
                    [
                        "id" => $order->id,
                        "title" => $title ?? 'Digital Assets',
                        "description" => 'Digital assets',
                        "quantity" => 1,
                        "unit_price" => (float) $order->total,
                        "currency_id" => "BRL"
                    ]
                ],
                "payer" => [
                    "email" => $order->user->email ?? "customer@example.com",
                    "name" => $order->user->name ?? "Customer",
                ],
                "external_reference" => (string) $order->id,
                "back_urls" => [
                    'success' => env('APP_URL') . '/payment/success/' . $order->id,
                    'failure' => env('APP_URL') . '/payment/failure/' . $order->id,
                    'pending' => env('APP_URL') . '/payment/pending/' . $order->id,
                ],
                'auto_return' => 'approved',
                'notification_url' => env('APP_URL') . '/payment/webhook',
                "statement_descriptor" => config('app.name'),
            ]);

            if ($order->status !== 'pending') {
                $order->update(['status' => 'pending']);
            }

            // Mercado Pago Checkout
            return redirect($preference->init_point);

        } catch (\Exception $e) {
            Log::error('Error while creating payment: ' . $e->getMessage());
            
            return back()->with('error', 'Error while creating payment. Try again.');
        }
    }

    /**
     * Payment success page
     */
    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        $paymentId = request('payment_id');
        
        if ($paymentId) {
            $this->verifyPaymentStatus($paymentId, $order);
        }

        return redirect()->route('myOrders')->with('message', 'Waiting for payment confirmation');
    }

    /**
     * Payment failure page
     */
    public function failure($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        if ($order->status === 'pending') {
            $order->update(['status' => 'rejected']);
        }

        return redirect()->route('myOrders')->with('error', '❌ Payment failed!');
    }

    /**
     * Payment pending page
     */
    public function pending($orderId)
    {
        $order = Order::findOrFail($orderId);

        return redirect()->route('myOrders')->with('warning', '⏳ Payment pending!');
    }

    /**
     * Mercado Pago webhoo to handle payment notifications
     */
    public function webhook(Request $request)
    {
        try {
            Log::info('Received mercado pago webhook', $request->all());

            $type = $request->input('type');
            $paymentId = $request->input('data.id');

            if ($type === 'payment' && $paymentId) {
                $client = new \MercadoPago\Client\Payment\PaymentClient();
                $payment = $client->get($paymentId);

                $order = Order::findOrFail($payment->external_reference);

                if ((float) $payment->transaction_amount !== (float) $order->total) {
                    Log::warning("Value mismatch {$paymentId}");
                    return response('Value mismatch', 400);
                }

                $this->processPaymentNotification($paymentId);
            }

            return response('OK', 200);

        } catch (\Exception $e) {
            Log::error('Webhook processing error: ' . $e->getMessage());
            return response('Error', 500);
        }
    }

    /**
     * Process Payment Notification
     */
    private function processPaymentNotification($paymentId)
    {
        try {
            $client = new PaymentClient();
            $payment = $client->get($paymentId);

            // Buscar o pedido pela referência externa
            $orderId = $payment->external_reference;
            $order = Order::find($orderId);

            if (!$order) {
                Log::warning("Order not found: {$orderId}");
                return;
            }

            // Map the payment status to order status
            $newStatus = $this->mapPaymentStatus($payment->status);

            if ($order->status !== $newStatus) {
                $order->update(['status' => $newStatus]);

                Log::info("Order status {$orderId} updated to: {$newStatus}");

                // Execute actions based on status change
                $this->handleStatusChange($order, $newStatus, $payment);
            }

        } catch (\Exception $e) {
            Log::error("Payment process error  {$paymentId}: " . $e->getMessage());
        }
    }

    /**
     * Verify Payment Status
     */
    private function verifyPaymentStatus($paymentId, Order $order)
    {
        try {
            $client = new PaymentClient();
            $payment = $client->get($paymentId);

            $newStatus = $this->mapPaymentStatus($payment->status);

            if ($order->status !== $newStatus) {
                $order->update(['status' => $newStatus]);
            }

        } catch (\Exception $e) {
            Log::error("Payment process error {$paymentId}: " . $e->getMessage());
        }
    }

    /**
     * Map MercadoPago status to internal order status
     */
    private function mapPaymentStatus($mercadoPagoStatus)
    {
        return match($mercadoPagoStatus) {
            'approved' => 'approved',
            'pending' => 'pending',
            'in_process' => 'pending',
            'rejected' => 'rejected',
            'cancelled' => 'cancelled',
            'refunded' => 'refunded',
            'charged_back' => 'charged_back',
            default => 'unknown'
        };
    }

    /**
     * Execute actions based on status change
     */
    private function handleStatusChange(Order $order, $newStatus, Payment $payment)
    {
        switch ($newStatus) {
            case 'approved':
                // Send confirmation email
                // Mail::to($oder->user->email)->send(new PaymentApprovedMail($order));
                
                Log::info("Payment approved to the order {$order->id}");
                break;

            case 'rejected':
                // Notify user of rejection
                // Mail::to($order->user->email)->send(new PaymentRejectedMail($order));
                
                Log::info("Payment rejecte to the order {$order->id}");
                break;

            case 'refunded':
                // Process Refund
                // ProcessRefundJob::dispatch($order);
                
                Log::info("Payment refunded to the order {$order->id}");
                break;
        }
    }
}