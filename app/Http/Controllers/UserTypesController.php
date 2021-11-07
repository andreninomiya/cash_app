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
        $this->request = $request;
    }

    public function create()
    {
        $this->validate($this->request, [
            "description" => "required",
        ]);

        $data = \Sanitizer::make($this->request->all(), UserTypes::getRules())->sanitize();

        UserTypes::create($data);

        return ResponseHelper::success("User-Type created");
    }

    public function update($typeId)
    {
        $type = UserTypes::find($typeId);

        if (empty($type))
            return ResponseHelper::exception("User-Type not found", 404, true);

        $data = \Sanitizer::make(UserTypes::attributesToUpdate($this->request->all()), UserTypes::getRules())->sanitize();

        $type->fill($data);
        $type->save();

        return ResponseHelper::success("User-Type updated");
    }

    public function show($typeId)
    {
        $type = UserTypes::find($typeId);

        if (empty($type))
            return ResponseHelper::exception("User-Type not found", 404, true);

        return ResponseHelper::success("User-Type to show", $type->toArray());
    }

    public function getAll()
    {
        $types = UserTypes::all()->toArray();

        return ResponseHelper::success("All user types", $types);
    }

    public function delete($typeId)
    {
        $type = UserTypes::find($typeId);

        if (empty($type))
            return ResponseHelper::exception("User-Type not found", 404, true);

        $removed = UserTypes::destroy($type->id);

        if ($removed == 0)
            return ResponseHelper::exception("User-Type not deleted", 402, true);

        return ResponseHelper::success("User-Type deleted");
    }
}
