<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client\StatusClient;

class StatusClientController extends Controller
{
    public function newStatus()
    {
        try{
            $newRegister = new StatusClient();
            $result = $newRegister->_store(request()->all());
            
            return response()->json(["error" => $result["error"], "message" => $result["message"], "data" => ""]);
        }
        catch(Exception $e)
        {
            return "Exception ".$e->getMessage();
        }
    }
    public function updateStatus()
    {
        try{
            $newRegister = new StatusClient();
            $result = $newRegister->_update(request()->all());

            return response()->json(["error" => $result["error"], "message" => $result["message"], "data" => ""]);
        }
        catch(Exception $e)
        {
            return "Exception: ".$e->getMessage();
        }
    }
    public function deleteStatus()
    {
        try{
            $deleteRegister = new StatusClient();
            $result = $deleteRegister->_delete(request('id_status_client'));

            return response()->json(['error' => $result["error"], "message" => $result["message"], "data" => ""]);
        }
        catch(Exception $e)
        {
            return "Exception: ".$e->getMessage();
        }
    }
    public function getStatus()
    {
        try{
            $register = new StatusClient();
            $result = $register->_getStatusClient(request()->all());

            return response()->json(["error" => $result["error"], "message" => $result["message"], "data" => $result["data"]]);
        }
        catch(Exceptio $e)
        {
            return "Exception: ".$e->getMessage();
        }
    }
}
