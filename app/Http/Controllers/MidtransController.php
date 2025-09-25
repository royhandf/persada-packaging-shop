<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;

class MidtransController extends Controller
{
    public function webhook(Request $request)
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');

        $payload = $request->all();

        Log::info('Midtrans Webhook Received:', $payload);

        if (empty($payload['order_id']) || empty($payload['signature_key'])) {
            Log::error('Midtrans Webhook: Invalid payload');
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        try {
            $orderId = $payload['order_id'];
            $signatureKey = hash('sha512', $orderId . $payload['status_code'] . $payload['gross_amount'] . config('services.midtrans.server_key'));

            if ($payload['signature_key'] != $signatureKey) {
                Log::warning('Midtrans Webhook: Invalid signature', ['order_id' => $orderId]);
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            $order = Order::where('order_number', $orderId)->first();
            if (!$order) {
                Log::warning('Midtrans Webhook: Order not found', ['order_id' => $orderId]);
                return response()->json(['message' => 'Order not found'], 404);
            }

            $transactionStatus = $payload['transaction_status'];
            $fraudStatus = $payload['fraud_status'];

            DB::transaction(function () use ($order, $transactionStatus, $fraudStatus) {
                if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                    if ($fraudStatus == 'accept') {
                        if ($order->status == 'pending_payment') {
                            $order->status = 'paid';
                            $order->paid_at = now();
                            $order->save();

                            foreach ($order->items as $item) {
                                $variant = ProductVariant::find($item->product_variant_id);
                                if ($variant) {
                                    $variant->stock -= $item->quantity;
                                    $variant->reserved_stock -= $item->quantity;
                                    $variant->save();
                                }
                            }
                        }
                    }
                } elseif ($transactionStatus == 'expire' || $transactionStatus == 'cancel' || $transactionStatus == 'deny') {
                    if ($order->status == 'pending_payment') {
                        $order->status = 'cancelled';
                        $order->save();

                        foreach ($order->items as $item) {
                            $variant = ProductVariant::find($item->product_variant_id);
                            if ($variant) {
                                $variant->reserved_stock -= $item->quantity;
                                $variant->save();
                            }
                        }
                    }
                }
            });

            Log::info('Midtrans Webhook: Processed successfully', ['order_id' => $orderId]);
            return response()->json(['message' => 'Notification processed successfully']);
        } catch (\Exception $e) {
            Log::error('Midtrans Webhook: Error processing', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error processing notification'], 500);
        }
    }
}
