<?php

namespace App\Repositories\V1\Customer;

use App\Enums\V1\PaymentStatus;
use App\Enums\V1\PaymentType;
use App\Interfaces\CustomerDepositRepositoryInterface;
use App\Models\Deposit;
use Illuminate\Support\Str;

class CutomerDepositRepository implements CustomerDepositRepositoryInterface
{
    public function index()
    {
        $deposit = Deposit::with('user')->where('customer_id', auth()->user()->customer->id)->paginate(15);

        return $deposit;
    }

    public function show($id)
    {
        $deposit = Deposit::with('user')->where('customer_id', auth()->user()->customer->id)->findOrFail($id);

        return $deposit;
    }

    public function store($request)
    {
        return Deposit::create($request + ['customer_id' => auth()->user()->customer->id]);
    }

    public function update($id, $request)
    {
    }

    public function destroy($id)
    {
    }

    public function payWithPaypal($id)
    {
        $deposit = Deposit::where([
            ['customer_id', auth()->user()->customer->id],
            ['payment_status', PaymentStatus::PENDING->value]
        ])->findOrFail($id);

        if (!$deposit) {
            $deposit = false;
        }

        $temp_token = Str::password(symbols: false);
        $deposit->update([
            'temporary_token' => $temp_token,
            'payment_type' => PaymentType::PAYPAL->value
        ]);

        return $deposit->temporary_token;
    }
}
