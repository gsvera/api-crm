<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Usuario;
use App\Models\Respuesta;

class UsuarioController extends Controller
{
    public function getUsers()
    {
        try{
            $user = User::select('id', 'name', 'first_name', 'last_name', 'email', 'active', 'enviroment', 'user_panel')->get();
            return response()->json(["error" => false, "message" => "", "data" => $user]);
        }
        catch(Exception $e)
        {
            return "Exception ".$e->getMessage();
        }
    }
    public function newUser()
    {
        try{
            
            $new_user = new Usuario;
            $result = $new_user->newUser(request()->all());
            if($result == 'error'){
                return response()->json(["error" => true, "message" => "Ya existe un usuario con ese email", "data" => ""]);
            }
            return response()->json(["error" => false, "message" => "Se guardo correctamente el registro", "data" => $result]);
        }
        catch(Exception $e)
        {
            return "Exception: ".$e->getMessage();
        }
    }
    public function deleteUser()
    {
        try{
            $userDelete = new Usuario;
            $result = $userDelete->deleteUser(request('id_user'));
            if($result == 'error'){
                return response()->json(["error" => true, "message" => "No se encontro al usuario", "data" => ""]);
            }
            
            return response()->json(["error" => false, "message" => "Usuario eliminado con exito", "data" => ""]);
        }
        catch(Exception $e)
        {
            return "Exception ".$e->getMessage();
        }
    }
    public function getUserById()
    {
        try{
            $getUser = new Usuario;
            $result = $getUser->getUserById(request('id_user'));

            if($result != null || $result != ''){
                return response()->json(["error" => false, "message" => "", "data" => $result]);
            }

            return response()->json(["error" => true, "message" => "No se encontro ningun registro", "data" => ""]);
        }
        catch(Exception $e)
        {
            return "Exception: ".$e->getMessage();
        }
    }
    public function updateUser()
    {
        try{
            $updateUser = new Usuario;
            
            $result = $updateUser->updateUser(request()->all());
            if($result == 'success'){
                return respones()->json(["error" => false, "message" => "Se actualizo el usuario correctamente", "data" => ""]);
            }
            return response()->json(["error" => true, "message" => "No se encontro ningun registro", "data" => $result]);
        }
        catch(Exception $e)
        {
            return "Exception: ". $e->getMessage();
        }
    }
    public function getEmployeesActive()
    {
        $res = new Respuesta;
        $users = new Usuario;

        try{
            // PRIMERO SE TIENE QUE RELACIONAR LOS EMPLEADOS CON LA COMPAÑIA ANTES DE ESTA CONSULTA
            $data = $users->_employeActiveForCompany(request('id_company'));
        }
        catch(Exception $e)
        {
            $res->error = true;
            $res->message = $e->getMessate();
        }

        return response()->json($res->getResult());
    }
}
