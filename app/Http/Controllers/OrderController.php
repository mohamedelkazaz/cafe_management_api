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
}
