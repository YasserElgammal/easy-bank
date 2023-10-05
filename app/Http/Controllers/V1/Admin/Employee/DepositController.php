<?php

namespace App\Http\Controllers\V1\Admin\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerDepositRequest;
use App\Http\Requests\V1\PayrollRequest;
use App\Http\Resources\V1\CustomerDepositResource;
use App\Http\Resources\V1\PayrollResource;
use App\Interfaces\DepositRepositoryInterface;
use App\Interfaces\PayrollRepositoryInterface;

class DepositController extends Controller
{
    private DepositRepositoryInterface $depositRepository;

    public function __construct(DepositRepositoryInterface $depositRepository)
    {
        $this->depositRepository = $depositRepository;
    }

    public function index()
    {
        $deposits = $this->depositRepository->index();

        return $this->successReponse(data: PayrollResource::collection($deposits));
    }

    public function store(CustomerDepositRequest $request)
    {
        $this->depositRepository->store($request->validated());

        return $this->successReponse(message: trans('app.record_added'));
    }

    public function show($id)
    {
        $payroll = $this->depositRepository->show($id);

        return $this->successReponse(data: CustomerDepositResource::make($payroll));
    }

    public function update($id, CustomerDepositRequest $request)
    {
        $this->depositRepository->update($id, $request->validated());

        return $this->successReponse(message: trans('app.record_updated'));
    }

    public function destroy($id)
    {
        $this->depositRepository->destroy($id);

        return $this->successReponse(message: trans('app.record_deleted'));
    }
}
