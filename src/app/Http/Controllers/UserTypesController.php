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

        return ResponseHelper::success('User-Type created');
    }

    public function update($typeId, $id)
    {
        // Busca o Tipo de Usuário
        $type = $this->searchOne($typeId, $id);

        // Verifica se o Tipo de ID é válido
        if ($type == 'invalid')
            return ResponseHelper::exception('Type not available', 404, true);

        // Verifica se o Tipo de Usuário existe
        if (empty($type))
            return ResponseHelper::exception('User-Type not found', 404, true);

        // Formata valores da requisição
        $data = \Sanitizer::make(UserTypes::attributesToUpdate($this->request->all()), UserTypes::getRules())->sanitize();

        // Salva as atualizações recebidas
        $type->fill($data);
        $type->save();

        return ResponseHelper::success('User-Type updated');
    }

    public function show($typeId, $id)
    {
        // Busca o Tipo de Usuário
        $type = $this->search($typeId, $id);

        // Verifica se o Tipo de ID é válido
        if ($type == 'invalid')
            return ResponseHelper::exception('Type not available', 404, true);

        // Verifica se o Tipo de Usuário existe
        if (empty($type))
            return ResponseHelper::exception('User-Type not found', 404, true);

        // Retorna o registro do Usuário
        return ResponseHelper::success('User-Type to show', $type->toArray());
    }

    public function getAll()
    {
        // Retorna todos os registros
        $types = UserTypes::all()->toArray();

        return ResponseHelper::success('All user types', $types);
    }

    public function delete($typeId, $id)
    {
        // Busca o Tipo de Usuário
        $type = $this->searchOne($typeId, $id);

        // Verifica se o Tipo de ID é válido
        if ($type == 'invalid')
            return ResponseHelper::exception('Type not available', 404, true);

        // Verifica se o Tipo de Usuário existe
        if (empty($type))
            return ResponseHelper::exception('User-Type not found', 404, true);

        // Realiza soft delete do Tipo de Usuário
        $removed = UserTypes::destroy($type->id);

        // Verifica se o Tipo de Usuário foi deletado
        if ($removed == 0)
            return ResponseHelper::exception('User-Type not deleted', 402, true);

        return ResponseHelper::success('User-Type deleted');
    }

    public function search($typeId, $id)
    {
        $type = '';
        $available_types = ['id', 'description'];

        // Verifica se o Tipo de ID confere com os tipos disponíveis
        if (!in_array($typeId, $available_types))
            return 'invalid';

        // Busca Usuário por ID
        if ($typeId == 'id')
            $type = UserTypes::find($id);

        // Busca Usuário por Descrição
        if ($typeId == 'description')
            $type = UserTypes::where('description', 'like', '%' . $id . '%')->get();

        return $type;
    }

    public function searchOne($typeId, $id)
    {
        // Busca Usuário por ID
        ($typeId == 'id') ? $type = UserTypes::find($id) : $type = 'invalid';

        return $type;
    }
}
