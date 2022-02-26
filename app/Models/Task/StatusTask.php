<?php

namespace App\Models\Task;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusTask extends Model
{
    use HasFactory;

    protected $table = 'crm_status_task';
    protected $primaryKey = 'id_status_task';
    public $timestamps = false;

    public function _store($data)
    {
        $res["error"] = false;
        $newRegister = new StatusTask();
        $newRegister->name_status = $data['name_status'];
        $newRegister->description_status = $data['description_status'];
        $newRegister->orden = $data["orden"];
        $newRegister->color = $data["color"];
        $newRegister->id_company = $data["id_company"];
        $newRegister->save();

        if($newRegister->id_status_task > 0){
            $res["message"] = "El registro se guardo correctamente";
        }else{
            $res["error"] = true;
            $res["message"] = "Error al guardar el registro";
        }

        return $res;
    }
    public function _update($data)
    {
        $res["error"] = false;

        $registerUpdate = $this->find($data["id_status_task"]);
        

        if($registerUpdate->count() > 0){
            $registerUpdate->name_status = $data["name_status"];
            $registerUpdate->description_status = $data["description_status"];
            $registerUpdate->orden = $data["orden"];
            $registerUpdate->color = $data["color"];
            $registerUpdate->save();

            $res["message"] = "Actualizado con éxito";
        }else{
            $res["error"] = true;
            $res["message"] = "No se encontro el registro";
        }

        return $res;
    }
    public function _delete($id)
    {
        $res["error"] = false;

        $register = $this->find($id);

        if($register->count() > 0){
            $register->delete();

            $res["message"] = "Registro eliminado con éxito";
        }else{
            $res["error"] = true;
            $res["message"] = "No se encontro el registro";
        }

        return $res;
    }
    public function _getStatusTask($id_company)
    {
        $res["error"] = false;

        $registers = $this->where('id_company', $id_company)->orderBy('orden')->get();

        if($registers->count() > 0){
            $res["message"] = "success";
            $res["data"] = $registers;
        }else{
            $res["message"] = "No se encontro ningun registro";
            $res["data"] = "";
        }
        return $res;
    }
}
