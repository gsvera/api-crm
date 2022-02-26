<?php

namespace App\Http\Controllers\Folio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Folio\Folio;
use App\Models\Respuesta;

class FolioController extends Controller
{
    public function getFolioCompany()
    {
        $res = new Respuesta;
        
        try{
            $register = new Folio;
            $res->data = $register->getFoliosCompany(request('id_company'));
        }
        catch(Exception $e)
        {
            $res->error = true;
            $res->message = $e->getMessage();
        }
        return response()->json(["error" => $res->error, "message" => $res->message, "data" => $res->data]);
    }
    public function updateFolio()
    {
        $res = new Respuesta;

        try{
            $register = new Folio;

            $res = $register->_updateFolio(request()->all());
        }
        catch(Exception $e)
        {
            $res->error = true;
            $res->message = $e->getMessage();
        }
        
        return response()->json(["error" => $res->error, "message" => $res->message, "data" => $res->data]);
    }
}
