<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use App\Models\Users;

class UsersController extends Controller
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
            'first_name' => 'required',
            'last_name' => 'required',
            'cpf_cnpj' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        // Formata valores da requisição
        $data = \Sanitizer::make($this->request->all(), Users::getRules())->sanitize();

        // Verifica se o CPF/CNPJ já existe no cadastro de algum usuário
        $userCpf = Users::where('cpf_cnpj', $data['cpf_cnpj'])->first();
        if (!empty($userCpf))
            return ResponseHelper::exception('CPF-CNPJ already registered', 404, true);

        // Verifica se o Email já existe no cadastro de algum usuário
        $userEmail = Users::where('email', $data['email'])->first();
        if (!empty($userEmail))
            return ResponseHelper::exception('Email already registered', 404, true);

        // Criptografa a senha com 'password_hash'
        $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);

        // Cria o registro do Usuário
        Users::create($data);

        return ResponseHelper::success('User created');
    }

    public function update($userId)
    {
        // Verifica se o Usuário existe
        $user = Users::find($userId);
        if (empty($user))
            return ResponseHelper::exception('User not found', 404, true);

        // Formata valores da requisição
        $data = \Sanitizer::make(Users::attributesToUpdate($this->request->all()), Users::getRules())->sanitize();

        // Salva as atualizações recebidas
        $user->fill($data);
        $user->save();

        return ResponseHelper::success('User updated');
    }

    public function show($userId)
    {
        // Verifica se o Saldo existe
        $user = Users::find($userId);
        if (empty($user))
            return ResponseHelper::exception('User not found', 404, true);

        // Retorna o registro do Usuário
        return ResponseHelper::success('User to show', $user->toArray());
    }

    public function getAll()
    {
        // Retorna todos os registros
        $users = Users::all()->toArray();

        return ResponseHelper::success('All users', $users);
    }

    public function delete($userId)
    {
        // Verifica se o Usuário existe
        $user = Users::find($userId);
        if (empty($user))
            return ResponseHelper::exception('User not found', 404, true);

        // Realiza soft delete do Usuário
        $removed = Users::destroy($user->id);

        // Verifica se o Usuário foi deletado
        if ($removed == 0)
            return ResponseHelper::exception('User not deleted', 402, true);

        return ResponseHelper::success('User deleted');
    }
}
