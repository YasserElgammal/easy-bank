<?php

namespace App\Repositories\V1\Customer;

use App\Interfaces\TransactionRepositoryInterface;
use App\Models\{Customer, Setting, Transaction};
use Illuminate\Support\Facades\DB;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function index()
    {
        $transactions = Transaction::with('senderUser')->where('receiver_id', auth()->user()->customer->id)->paginate(15);

        return $transactions;
    }

    public function show($id)
    {
        $transaction = Transaction::with('senderUser.user', 'receiverUser.user')
            ->where('receiver_id', auth()->user()->customer->id)->findOrFail($id);

        return $transaction;
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            $calculatedFees = $this->calculateTransferFees($request['amount']);
            $loggedCustomer = auth()->user()->customer;

            $transaction = Transaction::create($request + [
                'sender_id' => auth()->user()->customer->id,
                'net_amount' => $calculatedFees['netAmount'],
                'transfer_fees' => $calculatedFees['feesAmount'],
            ]);

            $loggedCustomer->decrementBalance($request['amount']);
            Customer::findOrFail($request['receiver_id'])->incrementBalance($request['receiver_id'], $request['amount']);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $transaction = false;
        }

        return $transaction;
    }

    public function update($id, $request)
    {
    }

    public function destroy($id)
    {
    }

    public function showTransactionBankProfits()
    {
        return Transaction::sum('transfer_fees');
    }

    private function calculateTransferFees($amount)
    {
        $transferFees = appSettings('transfer_fees');
        $feesAmount = ($amount * $transferFees) / 100;
        $netAmount = $amount * ((100 - $amount) / 100);

        return [
            'feesAmount' => $feesAmount,
            'netAmount' => $netAmount,
            'transferFees' => $transferFees
        ];
    }
}
