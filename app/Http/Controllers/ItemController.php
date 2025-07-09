<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    // ✅ عرض العناصر المرئية فقط (للمستخدم)
    public function index()
    {
        $items = Item::where('is_visible', true)->get()->map(function ($item) {
            $item->image_url = $item->image_url ? asset('storage/' . $item->image_url) : null;
            return $item;
        });

        return response()->json($items);
    }

    // ✅ عرض كل العناصر (للأدمن)
    public function allItemsForAdmin()
    {
        $items = Item::all()->map(function ($item) {
            $item->image_url = $item->image_url ? asset('storage/' . $item->image_url) : null;
            return $item;
        });

        return response()->json($items);
    }

    // ✅ إضافة صنف جديد
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
            'is_visible'  => 'boolean',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
        }

        $item = Item::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'quantity'    => $request->quantity,
            'is_visible'  => $request->is_visible ?? true,
            'image_url'   => $imagePath,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => '✅ تم إضافة الصنف بنجاح',
            'data'    => $item,
        ]);
    }

    // ✅ عرض صنف واحد
    public function show($id)
    {
        $item = Item::findOrFail($id);
        $item->image_url = $item->image_url ? asset('storage/' . $item->image_url) : null;

        return response()->json($item);
    }

    // ✅ تعديل صنف
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'name'        => 'sometimes|required|string',
            'description' => 'sometimes|nullable|string',
            'price'       => 'sometimes|required|numeric|min:0',
            'quantity'    => 'sometimes|required|integer|min:0',
            'is_visible'  => 'sometimes|boolean',
            'image'       => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($item->image_url) {
                Storage::disk('public')->delete($item->image_url);
            }
            $item->image_url = $request->file('image')->store('items', 'public');
        }

        $item->fill($request->except('image'));
        $item->save();

        $item->image_url = $item->image_url ? asset('storage/' . $item->image_url) : null;

        return response()->json([
            'status' => 'success',
            'message' => '✅ تم تحديث الصنف',
            'data' => $item
        ]);
    }

    // ✅ تغيير حالة الظهور
    public function toggleVisibility($id, Request $request)
    {
        $item = Item::findOrFail($id);
        $item->is_visible = $request->input('is_visible');
        $item->save();

        return response()->json([
            'message' => '✅ تم تحديث حالة الظهور',
            'item' => $item
        ]);
    }

    // ✅ حذف صنف
    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        if ($item->image_url) {
            Storage::disk('public')->delete($item->image_url);
        }

        $item->delete();

        return response()->json(['message' => '✅ تم حذف الصنف بنجاح']);
    }
}
