<?php

namespace App\Repositories\V1\Admin;

use App\Enums\V1\RoleType;
use App\Interfaces\EmployeeRepositoryInterface;
use App\Models\{Employee, User};

class EmployeeRepository implements EmployeeRepositoryInterface
{

    public function index()
    {
        $employees = Employee::with('user')->paginate(15);

        return $employees;
    }

    public function show($id)
    {
        $employee = Employee::with('user')->findOrFail($id);

        return $employee;
    }

    public function store($request)
    {
        $user = User::create($request + [
            'added_by' => auth()->id(),
            'role_type' => RoleType::EMPLOYEE->value
        ]);

        $user->employee()->save(new Employee());

        return $user;
    }

    public function update($id, $request)
    {
        $employee = Employee::findOrFail($id);
        $employee->update($request);

        return $employee;
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $user = User::findOrFail($employee->user_id);

        return $user->delete();
    }
}
