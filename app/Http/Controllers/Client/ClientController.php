<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Respuesta;
use App\Models\Client\Client;

class ClientController extends Controller
{
    public function newClient()
    {
        $res = new Respuesta;
        $register = new Client;

        try{
            $res->message = $register->_store(request()->all());
        }
        catch(Exception $e)
        {
            $res->error = true;
            $res->message = $e->getMessage();
        }

        return response()->json($res->getResult());
    }
    public function getClienteCompany()
    {
        $res = new Respuesta;
        $clients = new Client;

        try{
            $res->data = $clients->_getClientXCompany(request('id_company'));
        }
        catch(Exception $e)
        {
            $res->error = true;
            $res->message = $e->getMessage();
        }
        return response()->json($res->getResult());
    }
    public function disabledClient()
    {
        $res = new Respuesta;
        $client = new Client;

        try{
            $res->data = $client->_disabled(request()->all());
        }
        catch(Exception $e)
        {
            $res->error = true;
            $re->message = $e->getMessage();
        }
        return response()->json($res->getResult());
    }
    public function updateClient()
    {
        $res = new Respuesta;
        $client = new Client;

        try{
            $res->message = $client->_update(request()->all());
        }
        catch(Exception $e)
        {
            $res->error = true;
            $res->message = $e->getMessage();
        }

        return response()->json($res->getResult());
    }
    public function deleteClient()
    {
        $res = new Respuesta;
        $client = new Client;

        try{
            $res->message = $client->_delete(request('id_client'));
        }
        catch(Exception $e)
        {
            $res->error = true;
            $res->message = $e->getMessage();
        }

        return response()->json($res->getResult());
    }
}
