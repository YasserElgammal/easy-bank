<?php

namespace App\Http\Controllers\V1\Admin\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\PayrollRequest;
use App\Http\Resources\V1\PayrollResource;
use App\Interfaces\PayrollRepositoryInterface;

class PayrollController extends Controller
{
    public function __construct(private PayrollRepositoryInterface $payrollRepository)
    {
    }

    public function index()
    {
        $payrolls = $this->payrollRepository->index();

        return $this->successReponse(data: PayrollResource::collection($payrolls));
    }

    public function store(PayrollRequest $request)
    {
        $this->payrollRepository->store($request->validated());

        return $this->successReponse(message: trans('app.record_added'));
    }

    public function show($id)
    {
        $payroll = $this->payrollRepository->show($id);

        return $this->successReponse(data: PayrollResource::make($payroll));
    }

    public function update($id, PayrollRequest $request)
    {
        $transaction = $this->payrollRepository->update($id, $request->validated());

        return $this->successReponse(message: trans('app.record_updated'));
    }

    public function destroy($id)
    {
        $this->payrollRepository->destroy($id);

        return $this->successReponse(message: trans('app.record_deleted'));
    }
}
