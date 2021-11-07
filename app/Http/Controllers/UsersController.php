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
        $this->request = $request;
    }

    public function create()
    {
        $this->validate($this->request, [
            "first_name" => "required",
            "last_name" => "required",
            "cpf_cnpj" => "required",
            "email" => "required",
            "password" => "required",
        ]);

        $data = \Sanitizer::make($this->request->all(), Users::getRules())->sanitize();

        $userCpf = Users::where("cpf_cnpj", $data["cpf_cnpj"])->first();

        if (!empty($userCpf))
            return ResponseHelper::exception("CPF-CNPJ already registered", 404, true);

        $userEmail = Users::where("email", $data["email"])->first();

        if (!empty($userEmail))
            return ResponseHelper::exception("Email already registered", 404, true);

        $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);

        Users::create($data);

        return ResponseHelper::success("User created");
    }

    public function update($userId)
    {
        $user = Users::find($userId);

        if (empty($user))
            return ResponseHelper::exception("User not found", 404, true);

        $data = \Sanitizer::make(Users::attributesToUpdate($this->request->all()), Users::getRules())->sanitize();

        $user->fill($data);
        $user->save();

        return ResponseHelper::success("User updated");
    }

    public function show($userId)
    {
        $user = Users::find($userId);

        if (empty($user))
            return ResponseHelper::exception("User not found", 404, true);

        return ResponseHelper::success("User to show", $user->toArray());
    }

    public function getAll()
    {
        $users = Users::all()->toArray();

        return ResponseHelper::success("All users", $users);
    }

    public function delete($userId)
    {
        $user = Users::find($userId);

        if (empty($user))
            return ResponseHelper::exception("User not found", 404, true);

        $removed = Users::destroy($user->id);

        if ($removed == 0)
            return ResponseHelper::exception("User not deleted", 402, true);

        return ResponseHelper::success("User deleted");
    }
}
