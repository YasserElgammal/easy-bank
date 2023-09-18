<?php

namespace App\Repositories\V1\Customer;

use App\Interfaces\CustomerRepositoryInterface;
use App\Models\{Customer, User};

class CustomerRepository implements CustomerRepositoryInterface
{

    public function index()
    {
        $customers = Customer::with('user')->paginate(15);

        return $customers;
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);

        return $customer;
    }

    public function store($request)
    {
        $user = Customer::create($request);
        $user->customer()->save(new Customer());

        return $user;
    }

    public function update($id, $request)
    {
        $customer = Customer::with('user')->findOrFail($id);
        $customer->update($request);

        return $customer;
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $user = User::findOrFail($customer->user_id);

        return $user->delete();
    }
}
