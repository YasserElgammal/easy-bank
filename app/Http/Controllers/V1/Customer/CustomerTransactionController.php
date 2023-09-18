<?php

namespace App\Http\Controllers\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerTransactionRequest;
use App\Http\Resources\V1\TransactionResource;
use App\Interfaces\TransactionRepositoryInterface;


class CustomerTransactionController extends Controller
{
    private TransactionRepositoryInterface $transactionRepository;

    public function index()
    {
        $transactions = $this->transactionRepository->index();

        return $this->successReponse(data: TransactionResource::collection($transactions));
    }

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
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
}
