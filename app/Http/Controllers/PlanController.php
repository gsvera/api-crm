<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\SalePlan;

class PlanController extends Controller
{
    public function newPlan()
    {
        try{
            $newPlan = new Plan;
            
            $resp = $newPlan->_store(request()->all());

            if($resp == "success"){
                return response()->json(["error" => false, "message" => "", "data" => ""]);
            }
            return response()->json(["error" => true, "message" => "Hubo un error intentelo mas tarde", "data" => ""]);
        }
        catch(Exception $e)
        {
            return "Exception: ".$e->getMessage();
        }
    }
    public function getPlans()
    {
        try{
            $getPlans = new Plan;

            $resp = $getPlans->_getPlans();

            return response()->json(["error" => false, "message" => "", "data" => $resp]);
        }
        catch(Exception $e)
        {
            return "Exception: ".$e->getMessage();
        }
    }
    public function updatePlan()
    {
        try{
            $plan = new Plan;

            $result = $plan->_updatePlan(request()->all());

            if($result == 'success'){
                return response()->json(['error' => false, "message" => "Se actualizo correctamente el plan", "data" => ""]);
            }
            return response()->json(["error" => true, "message" => "Error al intentar actualizar el plan", "data" => ""]);

            
        }
        catch(Exception $e)
        {
            return "Exception: ".$e->getMessage();
        }
    }
    public function saveSalePlan()
    {
        try{
            $plan = new SalePlan;

            $result = $plan->_logSavePlan(request()->all());

            if($result == 'success'){
                return response()->json(['error' => false, "message" => "Plan guardado con exito", "data" => ""]);
            }
            return response()->json(['error' => true, "message" => "No se pudo guardar el registro", "data" => ""]);
        }
        catch(Exception $e)
        {
            return "Exception ".$e->getMessage();
        }
    }
    public function getEraserPlan()
    {
        try{
            $plans = new SalePlan;

            $resp = $plans->_getEraserPlan();

            return response()->json(['error' => false, 'message' => "", "data" => $resp]);
        }
        catch(Exception $e)
        {
            return "Exception ".$e->getMessage();
        }
    }
    public function deleteEraserSale()
    {
        try{
            $sale = new SalePlan;

            $resp = $sale->_deleteSale(request('id_sale'));

            if($resp == 'success'){
                return response()->json(["error" => false, "message" => "Se elimino el registro con éxito", "data" => ""]);
            }else{
                return response()->json(["error" => true, "message" => "Algo ocurrio, no se pudo eliminar el registro", "data" => ""]);
            }
        }
        catch(Exception $e)
        {
            return "Exception: ".$e->getMessage();
        }
    }
}
