<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // إنشاء طلب جديد
    public function store(Request $request)
    {
        // التحقق من البيانات المدخلة
        $validated = $request->validate([
            'total_price' => 'required|numeric',
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1'
        ]);

        // إنشاء الطلب
        $order = Order::create([
            'total_price' => $validated['total_price']
        ]);

        // إضافة العناصر المرتبطة بالطلب
        foreach ($validated['items'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $item['item_id'],
                'quantity' => $item['quantity']
            ]);
        }

        // إعادة الطلب مع العناصر المرتبطة
        return response()->json($order->load('orderItems'), 201);
    }

    // عرض كل الطلبات
    public function index()
    {
        $orders = Order::with('orderItems')->get();
        return response()->json($orders);
    }
}
