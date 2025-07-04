<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    // عرض كل العناصر (المنيو)
    public function index()
    {
        $items = Item::all();
        return response()->json($items);
    }

    // إضافة عنصر جديد للمنيو
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $imagePath = null;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('items', 'public');
    }

    $item = Item::create([
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'image_url' => $imagePath
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'تم إضافة الصنف بنجاح',
        'data' => $item
    ]);
}

    // عرض عنصر محدد
    public function show($id)
    {
        $item = Item::findOrFail($id);
        return response()->json($item);
    }

    // تحديث عنصر
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        $item->update($request->all());
        return response()->json($item);
    }

    // حذف عنصر
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        return response()->json(null,204);
      }
}