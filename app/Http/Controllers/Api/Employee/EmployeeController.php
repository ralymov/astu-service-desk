<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\Api\ApiController;
use App\Jobs\ImportEmployeesCsv;
use App\Models\Storage\Employee\Employee;
use Illuminate\Http\Request;

class EmployeeController extends ApiController
{

    public function index()
    {
        return Employee::with('department', 'position')->orderBy('id', 'desc')->get();
    }

    public function show(Employee $employees)
    {
        return $employees;
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'csv' => 'required|file|mimes:csv,txt',
        ]);
        ImportEmployeesCsv::dispatch($request->file('csv')->path());
        return response()->json('File imported', 201);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'position_id' => 'nullable|integer|exists:positions,id',
            'department_id' => 'nullable|integer|exists:departments,id',
        ]);
        $employee = Employee::create($request->all());
        return response()->json($employee, 201);
    }

    public function update(Request $request, Employee $employee)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'position_id' => 'nullable|integer|exists:positions,id',
            'department_id' => 'nullable|integer|exists:departments,id',
        ]);
        $employee->update($request->all());
        return response()->json($employee, 200);
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json(null, 204);
    }

}
