<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Models\UserTypes;

class UserTypesController extends Controller
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
            'description' => 'required',
        ]);

        // Formata valores da requisição
        $data = \Sanitizer::make($this->request->all(), UserTypes::getRules())->sanitize();

        // Cria o registro do Tipo de Usuário
        UserTypes::create($data);

        return ResponseHelper::success("User-Type created");
    }

    public function update($typeId)
    {
        // Verifica se o Tipo de Usuário existe
        $type = UserTypes::find($typeId);
        if (empty($type))
            return ResponseHelper::exception("User-Type not found", 404, true);

        // Formata valores da requisição
        $data = \Sanitizer::make(UserTypes::attributesToUpdate($this->request->all()), UserTypes::getRules())->sanitize();

        // Salva as atualizações recebidas
        $type->fill($data);
        $type->save();

        return ResponseHelper::success("User-Type updated");
    }

    public function show($typeId)
    {
        // Verifica se o Tipo de Usuário existe
        $type = UserTypes::find($typeId);
        if (empty($type))
            return ResponseHelper::exception("User-Type not found", 404, true);

        // Retorna o registro do Usuário
        return ResponseHelper::success("User-Type to show", $type->toArray());
    }

    public function getAll()
    {
        // Retorna todos os registros
        $types = UserTypes::all()->toArray();

        return ResponseHelper::success("All user types", $types);
    }

    public function delete($typeId)
    {
        // Verifica se o Tipo de Usuário existe
        $type = UserTypes::find($typeId);
        if (empty($type))
            return ResponseHelper::exception("User-Type not found", 404, true);

        // Realiza soft delete do Tipo de Usuário
        $removed = UserTypes::destroy($type->id);

        // Verifica se o Tipo de Usuário foi deletado
        if ($removed == 0)
            return ResponseHelper::exception("User-Type not deleted", 402, true);

        return ResponseHelper::success("User-Type deleted");
    }
}
