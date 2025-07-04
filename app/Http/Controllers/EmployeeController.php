<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // عرض كل الموظفين
    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }

    // إضافة موظف جديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'role' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email|unique:employees,email',
        ]);

        $employee = Employee::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'تم إضافة الموظف بنجاح',
            'data' => $employee,
        ], 201);
    }

    // عرض موظف محدد
    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json($employee);
    }

    // تحديث بيانات موظف
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string',
            'role' => 'sometimes|required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email|unique:employees,email,' . $id,
        ]);

        $employee->update($request->all());

        return response()->json($employee);
    }

    // حذف موظف
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return response()->json(null, 204);
    }
}
