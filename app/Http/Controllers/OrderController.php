<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Item;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // إنشاء طلب جديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1'
        ]);

        $totalPrice = 0;
        foreach ($validated['items'] as $itemData) {
            $item = Item::findOrFail($itemData['item_id']);
            $totalPrice += $item->price * $itemData['quantity'];
        }

       $order = Order::create([
    'total_price' => $totalPrice,
    'status' => 'pending' 
  ]);

        foreach ($validated['items'] as $itemData) {
            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $itemData['item_id'],
                'quantity' => $itemData['quantity']
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'تم إنشاء الطلب بنجاح',
            'data' => $order->load('orderItems.item')
        ], 201);
    }

    // عرض كل الطلبات مع الأصناف المرتبطة
    public function index()
    {
        $orders = Order::with('orderItems.item')->get();

        return response()->json([
            'status' => 'success',
            'data' => $orders
        ]);
    }

    // عرض طلب محدد
    public function show($id)
    {
        $order = Order::with('orderItems.item')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $order
        ]);
    }

    // تحديث حالة الطلب
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

    // حذف طلب
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(null, 204);
    }
    // تقرير إجمالي الطلبات والمبيعات
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
    // تقرير الطلبات حسب التاريخ
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
    $ordersCount = \App\Models\Order::count();
    $itemsCount = \App\Models\Item::count();
    $totalRevenue = \App\Models\Order::sum('total_price');

    return response()->json([
        'orders_count' => $ordersCount,
        'items_count' => $itemsCount,
        'total_revenue' => $totalRevenue
    ]);
}
// فلترة الطلبات حسب الحالة
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
    $validStatuses = ['pending', 'preparing', 'ready', 'served', 'cancelled'];

    if (!in_array($status, $validStatuses)) {
        return response()->json(['error' => 'Invalid status'], 400);
    }

    $orders = Order::with('orderItems.item')
        ->where('status', $status)
        ->get();

    return response()->json([
        'status' => 'success',
        'data' => $orders
    ]);
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
