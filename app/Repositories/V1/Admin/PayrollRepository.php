<?php

namespace App\Repositories\V1\Admin;

use App\Interfaces\PayrollRepositoryInterface;
use App\Models\Payroll;

class PayrollRepository implements PayrollRepositoryInterface
{

    public function index()
    {
        $employees = Payroll::with('employee')->paginate(15);

        return $employees;
    }

    public function show($id)
    {
        $employee = Payroll::with('employee')->findOrFail($id);

        return $employee;
    }

    public function store($request)
    {
        $payroll = Payroll::create($request);

        return $payroll;

    }

    public function update($id, $request)
    {
        $payroll = Payroll::findOrFail($id);
        $payroll->update($request);

        return $payroll;
    }

    public function destroy($id)
    {
        $payroll = Payroll::findOrFail($id);

        return $payroll->delete();
    }

}
