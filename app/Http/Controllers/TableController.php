<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    // عرض كل الطاولات مع الحالة
    public function index()
    {
        $tables = Table::all();
        return response()->json($tables);
    }

    // إضافة طاولة جديدة
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'status' => 'required|in:empty,reserved,occupied'
        ]);

        $table = Table::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'تم إضافة الطاولة بنجاح',
            'data' => $table
        ], 201);
    }

    // تحديث حالة طاولة
    public function update(Request $request, $id)
    {
        $table = Table::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string',
            'status' => 'sometimes|required|in:empty,reserved,occupied'
        ]);

        $table->update($request->all());

        return response()->json($table);
    }

    // حذف طاولة
    public function destroy($id)
    {
        $table = Table::findOrFail($id);
        $table->delete();

        return response()->json(null, 204);
    }
}
