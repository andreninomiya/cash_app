<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Helpers\ResponseHelper;

class Controller extends BaseController
{
    public function index()
    {
        return ResponseHelper::success("Welcome to ORQUESTRAGOV API 2020", ["version" => "1.0"]);
    }

}
