<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #333;
            font-size: 13px;
            line-height: 1.6;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .header,
        .footer {
            text-align: center;
        }

        .invoice-details {
            margin-bottom: 30px;
        }

        .invoice-details table {
            width: 100%;
        }

        .invoice-details .right {
            text-align: right;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .items-table th {
            background-color: #f2f2f2;
        }

        .summary {
            margin-top: 20px;
            float: right;
            width: 40%;
        }

        .summary table {
            width: 100%;
        }

        .summary td {
            padding: 5px;
        }

        .total {
            font-weight: bold;
        }

        .status-paid {
            color: #28a745;
            font-size: 24px;
            font-weight: bold;
            border: 2px solid #28a745;
            padding: 10px;
            display: inline-block;
            transform: rotate(-15deg);
            opacity: 0.5;
            margin-top: 20px;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>

<body>
    <div class="container">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%;">
                    {{-- Ganti dengan logo Anda jika ada --}}
                    <h1 style="color: #40916c;">Persada Packaging</h1>
                    <p>Jl. Industri Kemasan No. 1<br>Pasuruan, Jawa Timur, 67152</p>
                </td>
                <td style="width: 50%; text-align: right;">
                    <h2>INVOICE</h2>
                    <p><strong>Nomor:</strong> #{{ $order->order_number }}</p>
                    <p><strong>Tanggal:</strong> {{ $order->created_at->format('d F Y') }}</p>
                </td>
            </tr>
        </table>

        <div class="invoice-details" style="margin-top: 40px;">
            <h4>Ditagihkan Kepada:</h4>
            <p>
                <strong>{{ $order->shipping_address['receiver_name'] }}</strong><br>
                {{ $order->shipping_address['phone'] }}<br>
                {{ $order->shipping_address['street_address'] }},<br>
                {{ $order->shipping_address['area_name'] }}
            </p>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: right;">Harga Satuan</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>
                            {{ $item->product_name }}
                            <br><small>{{ $item->variant_name }}</small>
                        </td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}
                        </td>
                        <td style="text-align: right;">
                            Rp {{ number_format($item->price_at_purchase * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <table>
                <tr>
                    <td>Subtotal</td>
                    <td style="text-align: right;">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Ongkos Kirim</td>
                    <td style="text-align: right;">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                </tr>
                <tr class="total">
                    <td>GRAND TOTAL</td>
                    <td style="text-align: right;">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div class="clearfix"></div>

        @if ($order->status != 'pending_payment')
            <div style="text-align: left; margin-top: 50px;">
                <span class="status-paid">LUNAS</span>
            </div>
        @endif
    </div>
</body>

</html>
