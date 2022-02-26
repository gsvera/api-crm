<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;

class ModulesController extends Controller
{
    public function getModules()
    {
        try{
            $module = Module::get();

            return response()->json($module);
        }catch(Exception $e){
            return "Exeption ". $e->getMessage();
        }
        
    }
}
