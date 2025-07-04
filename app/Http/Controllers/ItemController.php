<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    // عرض كل الأصناف
    public function index()
    {
        $items = Item::all()->map(function ($item) {
            $item->image_url = $item->image_url ? asset('storage/' . $item->image_url) : null;
            return $item;
        });
        return response()->json($items);
    }

    // إضافة صنف جديد
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
            'image_url' => $imagePath,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'تم إضافة الصنف بنجاح',
            'data' => $item,
        ]);
    }

    // عرض صنف محدد
    public function show($id)
    {
        $item = Item::findOrFail($id);
        $item->image_url = $item->image_url ? asset('storage/' . $item->image_url) : null;
        return response()->json($item);
    }

    // تحديث صنف
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string',
            'description' => 'sometimes|nullable|string',
            'price' => 'sometimes|required|numeric',
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($item->image_url) {
                Storage::disk('public')->delete($item->image_url);
            }
            $imagePath = $request->file('image')->store('items', 'public');
            $item->image_url = $imagePath;
        }

        $item->fill($request->except('image'));
        $item->save();

        $item->image_url = $item->image_url ? asset('storage/' . $item->image_url) : null;

        return response()->json($item);
    }

    // حذف صنف
    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        if ($item->image_url) {
            Storage::disk('public')->delete($item->image_url);
        }

        $item->delete();

        return response()->json(null, 204);
    }
}
