<?php

namespace App\Http\Controllers\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerTransactionRequest;
use App\Http\Resources\V1\TransactionResource;
use App\Interfaces\TransactionRepositoryInterface;


class CustomerTransactionController extends Controller
{
    public function __construct(private TransactionRepositoryInterface $transactionRepository)
    {
    }

    public function index()
    {
        $transactions = $this->transactionRepository->index();

        return $this->successReponse(data: TransactionResource::collection($transactions));
    }

    public function store(CustomerTransactionRequest $request)
    {
        $transactionProcess = $this->transactionRepository->store($request->validated());

        return $this->successReponse(message: $transactionProcess ? "Done" : "Something wrong");
    }

    public function show($id)
    {
        $transaction = $this->transactionRepository->show($id);

        return $this->successReponse(data: TransactionResource::make($transaction));
    }

    public function showTransactionBankProfits()
    {
        $transactionProfits = $this->transactionRepository->showTransactionBankProfits();

        return response(['success' => true, 'data' => ['bank_profits' => $transactionProfits]]);
    }
}
