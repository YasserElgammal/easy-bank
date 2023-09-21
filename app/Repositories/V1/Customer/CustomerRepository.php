<?php

namespace App\Repositories\V1\Customer;

use App\Interfaces\CustomerRepositoryInterface;
use App\Models\{Customer, User};
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $user = User::create($request);

        if (request('avatar')) {
            $getFile = request('avatar')->store('images/customers');
            $avatar = $getFile;
        }

        $user->customer()->save(new Customer([
            'account_number' => Str::password(10, false, true, false, false),
            'dob'  => $request['dob'],
            'city'  => $request['city'],
            'phone' => $request['phone'],
            'balance' => $request['balance'],
            'avatar' => $avatar ?? null,
        ]));

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

        if ($customer->avatar && Storage::exists($customer->avatar)) {
                Storage::delete($customer->avatar);
        }

        return $user->delete();
    }
}
