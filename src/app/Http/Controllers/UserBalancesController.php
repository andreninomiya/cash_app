<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\UserBalancesHistorical;
use App\Models\Users;
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

        // Verifica se o Saldo desse usuário já existe
        $userBalance = UserBalances::where(["fk_user" => $data['fk_user']])->first();
        if (!empty($userBalance))
            return ResponseHelper::exception('User-Balance already exists', 404, true);

        // Verifica se o Usuário existe
        $user = Users::find($data['fk_user']);
        if (empty($user))
            return ResponseHelper::exception('User not found', 404, true);

        // Cria o registro do Saldo
        $balance = UserBalances::create($data);

        // Cria o registro no histórico de saldo do usuário
        $data['fk_balance'] = $balance->id;
        UserBalancesHistorical::create($data);

        return ResponseHelper::success('User-Balance created');
    }

    public function update($typeId, $id)
    {
        // Busca o Saldo
        $balance = $this->searchOne($typeId, $id);

        // Verifica se o Tipo de ID é válido
        if ($balance == 'invalid')
            return ResponseHelper::exception('Type not available', 404, true);

        // Verifica se o Saldo existe
        if (empty($balance))
            return ResponseHelper::exception('User-Balance not found', 404, true);

        // Formata valores da requisição
        $data = \Sanitizer::make(UserBalances::attributesToUpdate($this->request->all()), UserBalances::getRules())->sanitize();

        // Salva as atualizações recebidas
        $balance->fill($data);
        $balance->save();

        // Cria o registro no histórico de saldo do usuário
        $data['fk_user'] = $balance->fk_user;
        $data['fk_balance'] = $balance->id;
        UserBalancesHistorical::create($data);

        return ResponseHelper::success('User-Balance updated');
    }

    public function show($typeId, $id)
    {
        // Busca o Saldo
        $balance = $this->search($typeId, $id);

        // Verifica se o Tipo de ID é válido
        if ($balance == 'invalid')
            return ResponseHelper::exception('Type not available', 404, true);

        // Verifica se o Saldo existe
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

    public function delete($typeId, $id)
    {
        // Busca o Saldo
        $balance = $this->searchOne($typeId, $id);

        // Verifica se o Tipo de ID é válido
        if ($balance == 'invalid')
            return ResponseHelper::exception('Type not available', 404, true);

        // Verifica se o Saldo existe
        if (empty($balance))
            return ResponseHelper::exception('User-Balance not found', 404, true);

        // Realiza soft delete do Saldo
        $removed = UserBalances::destroy($balance->id);

        // Verifica se o Saldo foi deletado
        if ($removed == 0)
            return ResponseHelper::exception('User-Balance not deleted', 402, true);

        return ResponseHelper::success('User-Balance deleted');
    }

    public function getHistory($typeId, $id)
    {
        $balanceHistoric = '';
        $available_types = ['balance', 'user'];

        // Verifica se o Tipo de ID confere com os tipos disponíveis
        if (!in_array($typeId, $available_types))
            return ResponseHelper::exception('Type not available', 404, true);

        // Busca Histórico por ID de Saldo
        if ($typeId == 'balance')
            $balanceHistoric = UserBalancesHistorical::where('fk_balance', $id)->first();

        // Busca Histórico por ID de Usuário
        if ($typeId == 'user')
            $balanceHistoric = UserBalancesHistorical::where('fk_user', $id)->first();

        return ResponseHelper::success('All history balances', $balanceHistoric->toArray());
    }

    public function search($typeId, $id)
    {
        $balance = '';
        $available_types = ['id', 'user', 'value'];

        // Verifica se o Tipo de ID confere com os tipos disponíveis
        if (!in_array($typeId, $available_types))
            return 'invalid';

        // Busca Saldo por ID
        if ($typeId == 'id')
            $balance = UserBalances::find($id);

        // Busca Saldo por ID de Usuário
        if ($typeId == 'user')
            $balance = UserBalances::where('fk_user', $id)->first();

        // Busca Saldo por Valor
        if ($typeId == 'value')
            $balance = UserBalances::where('value', $id)->get();

        return $balance;
    }

    public function searchOne($typeId, $id)
    {
        $balance = '';
        $available_types = ['id', 'user'];

        // Verifica se o Tipo de ID confere com os tipos disponíveis
        if (!in_array($typeId, $available_types))
            return 'invalid';

        // Busca Saldo por ID
        if ($typeId == 'id')
            $balance = UserBalances::find($id);

        // Busca Saldo por ID de Usuário
        if ($typeId == 'user')
            $balance = UserBalances::where('fk_user', $id)->first();

        return $balance;
    }
}
