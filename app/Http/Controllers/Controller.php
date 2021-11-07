<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Helpers\ResponseHelper;

class Controller extends BaseController
{
    public function index()
    {
        return ResponseHelper::success("Welcome to PicPay CashApp 2021", ["version" => "1.0"]);
    }
}
