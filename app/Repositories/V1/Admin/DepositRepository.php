<?php

namespace App\Repositories\V1\Admin;

use App\Interfaces\DepositRepositoryInterface;
use App\Models\Deposit;

class DepositRepository implements DepositRepositoryInterface
{

    public function index()
    {
        $deposits = Deposit::with('customer')->paginate(15);

        return $deposits;
    }

    public function show($id)
    {
        $deposit = Deposit::with('customer')->findOrFail($id);

        return $deposit;
    }

    public function store($request)
    {
        $deposit = Deposit::create($request);

        return $deposit;
    }

    public function update($id, $request)
    {
    }

    public function destroy($id)
    {
        $deposit = Deposit::findOrFail($id);

        return $deposit->delete();
    }

}
