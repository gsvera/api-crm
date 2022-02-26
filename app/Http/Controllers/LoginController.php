<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Login;

class LoginController extends Controller
{
    public function login()
    {
        $login = new Login();
        
        $res = $login->login(request('email'), request('password'));

        if($res['success'] == true){
            return response()->json(["error" => false, "message" => "", "data" => $res]);
        }else{
            return response()->json(["error" => true, "message" => $res['message'], "data" => ""]);
        }
    }
    public function loginPanel()
    {
        $login = new Login();

        $res = $login->loginPanel(request('email'), request('password'));

        if($res['success'] == true){
            return response()->json(["error" => false, "message" => "", "data" => $res]);
        }else{
            return response()->json(["error" => true, "message" => "Usuario o contraseña incorrecta", "data" => ""]);
        }
    }
}
