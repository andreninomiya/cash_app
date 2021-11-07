<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\UserBalancesHistorical;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Models\UserBalances;

class UserBalancesController extends Controller
{
    public function __construct(Request $request)
    {
        // Método contrutor para receber as requisições
        $this->request = $request;
    }

    public function create()
    {
        // Define quais campos são obrigatórios
        $this->validate($this->request, [
            'fk_user' => 'required',
            'balance' => 'required',
        ]);

        // Formata valores da requisição
        $data = \Sanitizer::make($this->request->all(), UserBalances::getRules())->sanitize();

        // Cria o registro do Saldo
        $balance = UserBalances::create($data);

        // Cria o registro no histórico de saldo do usuário
        $data['fk_balance'] = $balance->id;
        UserBalancesHistorical::create($data);

        return ResponseHelper::success('User-Balance created');
    }

    public function update($balanceId)
    {
        // Verifica se o Saldo existe
        $balance = UserBalances::find($balanceId);
        if (empty($balance))
            return ResponseHelper::exception('User-Balance not found', 404, true);

        // Formata valores da requisição
        $data = \Sanitizer::make(UserBalances::attributesToUpdate($this->request->all()), UserBalances::getRules())->sanitize();

        // Salva as atualizações recebidas
        $balance->fill($data);
        $balance->save();

        // Cria o registro no histórico de saldo do usuário
        $data['fk_user'] = $balance->fk_user;
        $data['fk_balance'] = $balanceId;
        UserBalancesHistorical::create($data);

        return ResponseHelper::success('User-Balance updated');
    }

    public function show($balanceId)
    {
        // Verifica se o Saldo existe
        $balance = UserBalances::find($balanceId);
        if (empty($balance))
            return ResponseHelper::exception('User-Balance not found', 404, true);

        // Retorna o registro do Saldo
        return ResponseHelper::success('User-Balance to show', $balance->toArray());
    }

    public function getAll()
    {
        // Retorna todos os registros
        $balances = UserBalances::all()->toArray();

        return ResponseHelper::success('All user balances', $balances);
    }

    public function delete($balanceId)
    {
        // Verifica se o Saldo existe
        $balance = UserBalances::find($balanceId);
        if (empty($balance))
            return ResponseHelper::exception('User-Balance not found', 404, true);

        // Realiza soft delete do Saldo
        $removed = UserBalances::destroy($balance->id);

        // Verifica se o Saldo foi deletado
        if ($removed == 0)
            return ResponseHelper::exception('User-Balance not deleted', 402, true);

        return ResponseHelper::success('User-Balance deleted');
    }
}
