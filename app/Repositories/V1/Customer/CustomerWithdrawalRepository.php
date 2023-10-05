<?php

namespace App\Repositories\V1\Customer;

use App\Interfaces\CustomerWithdrawRepositoryInterface;
use App\Models\Withdrawal;

class CustomerWithdrawalRepository implements CustomerWithdrawRepositoryInterface
{
    public function index()
    {
        $withdrawal = Withdrawal::with('user')->where('customer_id', auth()->user()->customer->id)->paginate(15);

        return $withdrawal;
    }

    public function show($id)
    {
        $withdrawal = Withdrawal::with('user')->where('customer_id', auth()->user()->customer->id)->findOrFail($id);

        return $withdrawal;
    }

    public function store($request)
    {
        $withdrawal = Withdrawal::create($request + ['customer_id' => auth()->user()->customer->id]);

        return $withdrawal;
    }

    public function update($id, $request)
    {
    }

    public function destroy($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->is_approved) {
            return false;
        } else {
            $withdrawal->delete();
            return true;
        }
    }
}
