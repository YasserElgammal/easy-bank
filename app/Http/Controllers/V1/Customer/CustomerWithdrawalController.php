<?php

namespace App\Http\Controllers\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerWithdrawalRequest;
use App\Http\Resources\V1\CustomerWithdrawalResource;
use App\Interfaces\CustomerWithdrawRepositoryInterface;

class CustomerWithdrawalController extends Controller
{
    private CustomerWithdrawRepositoryInterface $customerWithdrawalRepository;

    public function __construct(CustomerWithdrawRepositoryInterface $customerWithdrawalRepository)
    {
        $this->customerWithdrawalRepository = $customerWithdrawalRepository;
    }

    public function index()
    {
        $withdrawals = $this->customerWithdrawalRepository->index();

        return $this->successReponse(data: CustomerWithdrawalResource::collection($withdrawals));
    }

    public function store(CustomerWithdrawalRequest $request)
    {
        $this->customerWithdrawalRepository->store($request->validated());

        return $this->successReponse(message: trans('app.record_added'));
    }

    public function show($id)
    {
        $withdrawal = $this->customerWithdrawalRepository->show($id);

        return $this->successReponse(data: CustomerWithdrawalResource::make($withdrawal));
    }

    public function destroy($id)
    {
       $withdrawal =  $this->customerWithdrawalRepository->destroy($id);

        return $this->successReponse(message: $withdrawal ? trans('app.record_deleted') : trans('app.cannot_deleted'));
    }
}
