<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Respuesta;
use App\Models\Company_X_Usuario;

class CompanyController extends Controller
{
    public function newCompany()
    {
        try{
            $newCompany = new Company;
            $result = $newCompany->_newCompany(request()->all());
            
            if($result['success'] == 'success'){
                return response()->json(["error" => false, "message" => "", "data" => ""]);
            }else{
                return response()->json(["error" => true, 'message' => $result['message'], "data" => ""]);
            }
            return response()->json(["error" => true, 'message' => "No se guardo el registro correctamente", "data" => ""]);
        }
        catch(Exception $e)
        {
            return "Exception: ".$e->getMessage();
        }
    }
    public function getCompanys()
    {
        try{
            $companys = new Company;

            return response()->json(["error" => false, "message" => "", "data" => $companys->_allCompanys()]);
        }
        catch(Exception $e)
        {
            return "Exception: ".$e->getMessage();
        }
    }
    public function deleteCompany()
    {
        try{
            $deleteCompany = new Company;

            $result = $deleteCompany->_deleteCompany(request('id_company'));

            if($result == "success"){
                return response()->json(["error" => false, "message" => "", "data" => ""]);
            }
            return response()->json(["error" => false, "message" => "Error al intentar eliminar la compañia", "data" => ""]);
        }
        catch(Exception $e)
        {
            return "Exception: ".$e->getMessage();
        }
    }
    public function updateCompany()
    {
        try{
            $updateCom = new Company;

            $result = $updateCom->_updateCompany(request()->all());
            
            if($result['error'] == true){
                return response()->json(["error" => true, "message" => $result['message'], "data" => ""]);
            }
            return response()->json(["error" => false, "message" => "", "data" => ""]);
        }
        catch(Exception $e)
        {
            return "Exception: ".$e->getMessage();
        }
    }
    public function addUserRelathion()
    {
        $res = new Respuesta;
        $relathion = new Company_X_Usuario;

        try{
            $res->message = $relathion->_store(request()->all());
        }
        catch(Exception $e)
        {
            $res->error = true;
            $res->message = $e->getMessage();
        }

        return response()->json($res->getResult());
    }
    public function getUerRelathion()
    {
        $res = new Respuesta;
        $relathion = new Company_X_Usuario;

        try{
            $result = $relathion->_getData(request('id_company'));
            $res->data = $result;
        }
        catch(Exception $e)
        {
            $res->error = true;
            $res->message = $e->getMessage();
        }
        return response()->json($res->getResult());
    }
    public function deleteUserRelathion()
    {
        $res = new Respuesta;
        $relation = new Company_X_Usuario;

        try{
            $result = $relation->_deleteRelathion(request("id_pivote"));
            $res->message = $result;
        }
        catch(Exception $e)
        {
            $res->error = true;
            $res->message = $e->getmessage();
        }

        return response()->json($res->getResult());
    }
}
