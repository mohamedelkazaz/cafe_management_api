<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use Illuminate\Http\Request;

class RawMaterialController extends Controller
{
    // عرض كل المواد الخام مع إشارة للتنبيه
    public function index()
    {
        $materials = RawMaterial::all()->map(function ($material) {
            $material->is_alert = $material->quantity <= $material->alert_quantity;
            return $material;
        });

        return response()->json($materials);
    }

    // إضافة مادة خام جديدة
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:raw_materials,name',
            'quantity' => 'required|integer|min:0',
            'alert_quantity' => 'required|integer|min:0',
        ]);

        $material = RawMaterial::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'تم إضافة المادة الخام بنجاح',
            'data' => $material,
        ], 201);
    }

    // عرض مادة خام محددة
    public function show($id)
    {
        $material = RawMaterial::findOrFail($id);
        $material->is_alert = $material->quantity <= $material->alert_quantity;

        return response()->json($material);
    }

    // تحديث مادة خام
    public function update(Request $request, $id)
    {
        $material = RawMaterial::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|unique:raw_materials,name,' . $id,
            'quantity' => 'sometimes|required|integer|min:0',
            'alert_quantity' => 'sometimes|required|integer|min:0',
        ]);

        $material->update($request->all());

        $material->is_alert = $material->quantity <= $material->alert_quantity;

        return response()->json($material);
    }

    // حذف مادة خام
    public function destroy($id)
    {
        $material = RawMaterial::findOrFail($id);
        $material->delete();

        return response()->json(null, 204);
    }
}
