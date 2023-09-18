<?php

namespace App\Http\Controllers\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Api\RegisterUserRequest;
use App\Http\Resources\V1\CustomerResource;
use App\Interfaces\CustomerRepositoryInterface;

class CustomerController extends Controller
{
    private CustomerRepositoryInterface $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function index()
    {
        $customers = $this->customerRepository->index();

        return $this->successReponse(data: CustomerResource::collection($customers));
    }

    public function store(RegisterUserRequest $request)
    {
        $this->customerRepository->store($request->validated());

        return $this->successReponse(message: trans('app.record_added'));
    }

    public function show($id)
    {
        $customer = $this->customerRepository->show($id);

        return $this->successReponse(data: CustomerResource::make($customer));
    }

    public function update($id, $request)
    {
        $this->customerRepository->update($id, $request);

        return $this->successReponse(message: trans('app.record_updated'));
    }

    public function destroy($id)
    {
        $this->customerRepository->destroy($id);

        return $this->successReponse(message: trans('app.record_deleted'));
    }

}
