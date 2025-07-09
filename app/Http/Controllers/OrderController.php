<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // إنشاء طلب جديد
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();

        // إنشاء الطلب
        $order = Order::create([
            'user_id' => $user ? $user->id : null,
            'total_price' => $request->total_price,
            'status' => 'pending',
        ]);

        // حفظ كل منتج في order_items
        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $item['item_id'],
                'quantity' => $item['quantity'],
            ]);
        }

        return response()->json([
            'message' => 'تم حفظ الطلب بنجاح ✅',
            'order_id' => $order->id,
        ], 201);
    }

    public function index()
    {
        $orders = Order::with('orderItems.item')->get();

        return response()->json([
            'status' => 'success',
            'data' => $orders
        ]);
    }

    public function show($id)
    {
        $order = Order::with('orderItems.item')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $order
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,preparing,ready,served,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return response()->json([
            'status' => 'success',
            'message' => 'تم تحديث حالة الطلب',
            'data' => $order
        ]);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(null, 204);
    }

    public function reportSummary()
    {
        $totalOrders = Order::count();
        $totalSales = Order::sum('total_price');
        $todayOrders = Order::whereDate('created_at', now()->toDateString())->count();

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_orders' => $totalOrders,
                'total_sales' => $totalSales,
                'today_orders' => $todayOrders,
            ]
        ]);
    }

    public function report(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ]);

        $orders = Order::with('orderItems.item')
            ->whereBetween('created_at', [$request->from, $request->to])
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $orders
        ]);
    }

    public function dashboardStats()
    {
        $ordersCount = Order::count();
        $itemsCount = Item::count();
        $totalRevenue = Order::sum('total_price');

        return response()->json([
            'orders_count' => $ordersCount,
            'items_count' => $itemsCount,
            'total_revenue' => $totalRevenue
        ]);
    }

    public function filterByStatus($status)
    {
        $validStatuses = ['pending', 'preparing', 'ready', 'served', 'cancelled'];

        if (!in_array($status, $validStatuses)) {
            return response()->json([
                'status' => 'error',
                'message' => 'حالة الطلب غير صالحة'
            ], 400);
        }

        $orders = Order::with('orderItems.item')
            ->where('status', $status)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $orders
        ]);
    }

    public function getByStatus($status)
    {
        return $this->filterByStatus($status);
    }

    public function summary()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_price');
        $byStatus = Order::selectRaw('status, COUNT(*) as count')
                        ->groupBy('status')
                        ->get();

        return response()->json([
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue,
            'orders_by_status' => $byStatus
        ]);
    }
}
