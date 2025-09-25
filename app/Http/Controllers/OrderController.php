<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->orders();

        if ($request->filled('status')) {
            $status = $request->status;
            if ($status == 'unpaid') {
                $query->where('status', 'pending_payment');
            } elseif ($status == 'processing') {
                $query->whereIn('status', ['paid', 'processing']);
            } elseif ($status == 'shipped') {
                $query->where('status', 'shipped');
            } elseif ($status == 'completed') {
                $query->whereIn('status', ['delivered', 'completed']);
            }
        }

        $orders = $query->with('items.productVariant.product.primaryImage')
            ->latest()
            ->paginate(10);

        return view('pages.home.order', compact('orders'));
    }

    public function orderDetail(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(404);
        }

        return view('pages.home.order-detail', compact('order'));
    }

    public function invoice(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(404);
        }

        $pdf = Pdf::loadView('pages.home.invoice', compact('order'));

        $fileName = 'invoice-' . $order->order_number . '.pdf';

        return $pdf->download($fileName);
    }
}
