<?php

namespace App\Http\Controllers\Task;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Task\StatusTask;

class StatusTaskController extends Controller
{
    public function newStatus()
    {
        try{
            $newRegister = new StatusTask();

            $result = $newRegister->_store(request()->all());

            return response()->json(["error" => $result["error"], "message" => $result['message'], "data" => ""]);
        }
        catch(Exception $e)
        {
            return "Exception: ".$e->getMessage();
        }
    }
    public function updateStatus()
    {
        try{
            $newRegister = new StatusTask();

            $result = $newRegister->_update(request()->all());

            return response()->json(["error" => $result["error"], "message" => $result["message"], "data" => ""]);
        }
        catch(Exception $e)
        {
            return "Exception: ".$e->getMessage();
        }
    }
    public function deleteTask()
    {
        try{
            $deleteRegister = new StatusTask();

            $result = $deleteRegister->_delete(request('id_status_task'));

            return response()->json(["error" => $result["error"], "message" => $result["message"], "data" => ""]);
        }
        catch(Exception $e)
        {
            return "Exception: ".$e->getMessage();
        }
    }
    public function getStatus()
    {
        try{
            $register = new StatusTask();

            $result = $register->_getStatusTask(request("id_company"));

            return response()->json(["error" => $result["error"], "message" => $result["message"], "data" => $result["data"]]);
        }
        catch(Exception $e)
        {
            return "Exception: ". $e->getMessage();
        }
    }
}
