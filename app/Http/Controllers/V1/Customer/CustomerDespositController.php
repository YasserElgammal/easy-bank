<?php

namespace App\Http\Controllers\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerDepositRequest;
use App\Http\Resources\V1\CustomerDepositResource;
use App\Interfaces\CustomerDepositRepositoryInterface;
use Illuminate\Http\Request;

class CustomerDespositController extends Controller
{
    public function __construct(private CustomerDepositRepositoryInterface $customerDepositRepository)
    {
    }

    public function index()
    {
        $deposits = $this->customerDepositRepository->index();

        return $this->successReponse(data: CustomerDepositResource::collection($deposits));
    }

    public function store(CustomerDepositRequest $request)
    {
        $this->customerDepositRepository->store($request->validated());

        return $this->successReponse(message: trans('app.record_added'));
    }

    public function show($id)
    {
        $deposit = $this->customerDepositRepository->show($id);

        return $this->successReponse(data: CustomerDepositResource::make($deposit));
    }

    public function payWithPaypal(Request $request)
    {
        $request->validate(['id' => ['required', 'exists:deposits,id']]);

        $token = $this->customerDepositRepository->payWithPaypal($request->id);

        if (!$token) {
            return $this->failResponse(message: __('app.failed_to_create_token'));
        }

        return $this->successReponse(message: route('paypal.payment', $token));
    }
}
