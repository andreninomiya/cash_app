<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Models\UserBalances;

class UserBalancesController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function create()
    {
        $this->validate($this->request, [
            "balance" => "required",
        ]);

        $data = \Sanitizer::make($this->request->all(), UserBalances::getRules())->sanitize();

        UserBalances::create($data);

        return ResponseHelper::success("User-Balance created");
    }

    public function update($balanceId)
    {
        $balance = UserBalances::find($balanceId);

        if (empty($balance))
            return ResponseHelper::exception("User-Balance not found", 404, true);

        $data = \Sanitizer::make(UserBalances::attributesToUpdate($this->request->all()), UserBalances::getRules())->sanitize();

        $balance->fill($data);
        $balance->save();

        return ResponseHelper::success("User-Balance updated");
    }

    public function show($balanceId)
    {
        $balance = UserBalances::find($balanceId);

        if (empty($balance))
            return ResponseHelper::exception("User-Balance not found", 404, true);

        return ResponseHelper::success("User-Balance to show", $balance->toArray());
    }

    public function getAll()
    {
        $balances = UserBalances::all()->toArray();

        return ResponseHelper::success("All user balances", $balances);
    }

    public function delete($balanceId)
    {
        $balance = UserBalances::find($balanceId);

        if (empty($balance))
            return ResponseHelper::exception("User-Balance not found", 404, true);

        $removed = UserBalances::destroy($balance->id);

        if ($removed == 0)
            return ResponseHelper::exception("User-Balance not deleted", 402, true);

        return ResponseHelper::success("User-Balance deleted");

    }
}
