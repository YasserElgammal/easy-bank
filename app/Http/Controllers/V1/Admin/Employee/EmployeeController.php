<?php

namespace App\Http\Controllers\V1\Admin\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Api\RegisterUserRequest;
use App\Http\Resources\V1\EmployeeResource;
use App\Interfaces\EmployeeRepositoryInterface;

class EmployeeController extends Controller
{
    public function __construct(private EmployeeRepositoryInterface $employeeRepository)
    {
    }

    public function store(RegisterUserRequest $request)
    {
        $this->employeeRepository->store($request->validated());

        return $this->successReponse(message: trans('app.record_added'));
    }

    public function show($id)
    {
        $employee = $this->employeeRepository->show($id);

        return $this->successReponse(data: EmployeeResource::make($employee));
    }

    public function update($id, $request)
    {
        $this->employeeRepository->update($id, $request);

        return $this->successReponse(message: trans('app.record_updated'));
    }

    public function destroy($id)
    {
        $this->employeeRepository->destroy($id);

        return $this->successReponse(message: trans('app.record_deleted'));
    }
}
