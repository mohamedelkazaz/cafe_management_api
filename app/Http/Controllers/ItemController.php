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
        $item = Item::create($request->all());
        return response()->json($item, 201);
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