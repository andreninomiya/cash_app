<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\UserBalances;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Models\Transactions;

class TransactionsController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function create()
    {
        $this->validate($this->request, [
            "value" => "required",
        ]);

        $data = \Sanitizer::make($this->request->all(), Transactions::getRules())->sanitize();

        Transactions::create($data);

        return ResponseHelper::success("Transaction created");
    }

    public function update($transactionId)
    {
        $transaction = Transactions::find($transactionId);

        if (empty($transaction))
            return ResponseHelper::exception("Transaction not found", 404, true);

        $data = \Sanitizer::make(Transactions::attributesToUpdate($this->request->all()), Transactions::getRules())->sanitize();

        $transaction->fill($data);
        $transaction->save();

        return ResponseHelper::success("Transaction updated");
    }

    public function show($transactionId)
    {
        $transaction = Transactions::find($transactionId);

        if (empty($transaction))
            return ResponseHelper::exception("Transaction not found", 404, true);

        return ResponseHelper::success("Transaction to show", $transaction->toArray());
    }

    public function getAll()
    {
        $transactions = Transactions::all()->toArray();

        return ResponseHelper::success("All transactions", $transactions);
    }

    public function delete($transactionId)
    {
        $transaction = Transactions::find($transactionId);

        if (empty($transaction))
            return ResponseHelper::exception("Transaction not found", 404, true);

        $removed = Transactions::destroy($transaction->id);

        if ($removed == 0)
            return ResponseHelper::exception("Transaction not deleted", 402, true);

        return ResponseHelper::success("Transaction deleted");
    }

    public function makeTransaction()
    {
        $this->validate($this->request, [
            "payer" => "required",
            "payee" => "required",
            "value" => "required",
        ]);

        $data = \Sanitizer::make($this->request->all(), Transactions::getRules())->sanitize();

        $userBalance = UserBalances::find($data['payer']);

        ResponseHelper::postman($userBalance);

        return ResponseHelper::success("Transaction realized");
    }
}
