<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $statuses = ['pending_payment', 'paid', 'processing', 'shipped', 'delivered', 'completed', 'cancelled', 'refunded'];
        $currentStatus = $request->query('status');

        $orderQuery = Order::latest()->with('user');

        if (in_array($currentStatus, $statuses)) {
            $orderQuery->where('status', $currentStatus);
        }

        $orders = $orderQuery->paginate(10)->withQueryString();

        return view('pages.dashboard.order', [
            'orders' => $orders,
            'statuses' => $statuses,
            'currentStatus' => $currentStatus,
        ]);
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.productVariant.product.primaryImage']);

        $statuses = ['pending_payment', 'paid', 'processing', 'shipped', 'delivered', 'completed', 'cancelled', 'refunded'];

        return view('pages.dashboard.order-detail', [
            'order' => $order,
            'statuses' => $statuses
        ]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $statuses = ['pending_payment', 'paid', 'processing', 'shipped', 'delivered', 'completed', 'cancelled', 'refunded'];

        $request->validate([
            'status' => 'required|in:' . implode(',', $statuses),
        ]);

        $newStatus = $request->status;
        $oldStatus = $order->status;

        if ($newStatus === 'cancelled' && $oldStatus === 'pending_payment') {
            $order->status = $newStatus;
            $order->save();

            foreach ($order->items as $item) {
                $variant = $item->productVariant;
                if ($variant) {
                    $variant->decrement('reserved_stock', $item->quantity);
                }
            }

            $admins = User::whereIn('role', ['admin', 'superadmin'])->get();
            Notification::send($admins, new OrderCancelledNotification($order));
        } else {
            $order->update(['status' => $newStatus]);
        }

        return redirect()->route('dashboard.orders.show', $order->order_number)->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function invoice(Order $order)
    {
        $order->load('items');

        $pdf = Pdf::loadView('pages.invoice', compact('order'));

        $fileName = 'invoice-' . $order->order_number . '.pdf';

        return $pdf->download($fileName);
    }
}
