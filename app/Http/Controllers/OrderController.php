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
        // ✅ التحقق من صحة البيانات
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1'
        ]);

        // ✅ حساب السعر الإجمالي
        $totalPrice = 0;

        foreach ($validated['items'] as $itemData) {
            $item = Item::findOrFail($itemData['item_id']);
            $totalPrice += $item->price * $itemData['quantity'];
        }

        // ✅ إنشاء الطلب
        $order = Order::create([
            'total_price' => $totalPrice
        ]);

        // ✅ إضافة العناصر المرتبطة بالطلب
        foreach ($validated['items'] as $itemData) {
            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $itemData['item_id'],
                'quantity' => $itemData['quantity']
            ]);
        }

        // ✅ تحميل الطلب مع العناصر المرتبطة
        return response()->json([
            'status' => 'success',
            'message' => 'تم إنشاء الطلب بنجاح',
            'data' => $order->load('orderItems.item') // يجلب الأصناف المرتبطة
        ], 201);
    }

    // عرض كل الطلبات
    public function index()
    {
        $orders = Order::with('orderItems.item')->get();

        return response()->json([
            'status' => 'success',
            'data' => $orders
        ]);
    }
}