<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product\TypeProduct;

class TypeProductController extends Controller
{
    public function newType()
    {
        try{
            $newRegister = new TypeProduct();
            $result = $newRegister->_store(request()->all());
            return response()->json(["error" => $result["error"], "message" => $result["message"], "data" => ""]);
        }
        catch(Exception $e)
        {
            return "Exception: ".$e->getMessage();
        }
    }
    public function getType()
    {
        try{
            $getRegister = new TypeProduct();
            $result = $getRegister->_getTypeProduct(request("id_company"));
            return response()->json(["error" => $result["error"], "message" => $result["message"], "data" => $result["data"]]);
        }
        catch(Exception $e)
        {
            return "Exception: ".$e-getMessage();
        }
    }
    public function updateType()
    {
        try{
            $register = new TypeProduct();
            $result = $register->_update(request()->all());
            return response()->json(["error" => $result["error"], "message" => $result["message"], "data" => ""]);
        }
        catch(Exception $e)
        {
            return "Exception: " . $e->getMessage();
        }
    }
    public function deleteType()
    {
        try{
            $deleteRegister = new TypeProduct();
            $result = $deleteRegister->_delete(request('id_tipo'));
            return response()->json(["error" => $result["error"], "message" => $result["message"], "data" => ""]);
        }
        catch(Exception $e)
        {
            return "Exception: ".$e->getMessage();
        }
    }
}
