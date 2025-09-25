<?php

namespace App\Services;

use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentService
{
    public function __construct()
    {
        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    public function createTransaction(Order $order)
    {
        $itemDetails = $order->items->map(function ($item) {
            return [
                'id'       => $item->product_variant_id,
                'price'    => (int) $item->price_at_purchase,
                'quantity' => $item->quantity,
                'name'     => substr($item->product_name . ' (' . $item->variant_name . ')', 0, 50)
            ];
        });

        if ($order->shipping_cost > 0) {
            $itemDetails->push([
                'id'       => 'SHIPPING_COST',
                'price'    => (int) $order->shipping_cost,
                'quantity' => 1,
                'name'     => 'Ongkos Kirim'
            ]);
        }

        $params = [
            'transaction_details' => [
                'order_id'     => $order->order_number,
                'gross_amount' => (int) $order->grand_total,
            ],
            'item_details' => $itemDetails->toArray(),
            'customer_details' => [
                'first_name' => $order->user->name,
                'email'      => $order->user->email,
                'phone'      => $order->shipping_address['phone'] ?? $order->user->phone,
                'shipping_address' => [
                    'first_name'   => $order->shipping_address['receiver_name'],
                    'phone'        => $order->shipping_address['phone'],
                    'address'      => $order->shipping_address['street_address'],
                    'city'         => $order->shipping_address['area_name'],
                ]
            ],
            'enabled_payments' => [$this->mapPaymentMethod($order->payment_method)],
        ];

        if (empty($params['enabled_payments'][0])) {
            unset($params['enabled_payments']);
        }

        $snapToken = Snap::getSnapToken($params);

        $order->update(['payment_token' => $snapToken]);

        return $order;
    }

    private function mapPaymentMethod(string $method)
    {
        $map = [
            'bca_va' => 'bca_va',
            'bri_va' => 'bri_va',
            'bni_va' => 'bni_va',
            'mandiri_va' => 'echannel',
            'qris' => 'qris',
            'gopay' => 'gopay',
            'shopeepay' => 'shopeepay',
        ];

        return $map[$method] ?? null;
    }
}
