<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusClient extends Model
{
    use HasFactory;

    protected $table = 'crm_status_client';
    protected $primaryKey = 'id_status_client';
    public $timestamps = false;

    public function _store($data)
    {
        $res['error'] = false;
        $newRegister = new StatusClient();

        $newRegister->name_status = $data['name_status'];
        $newRegister->description_status = $data['description_status'];
        $newRegister->orden = $data['orden'];
        $newRegister->color = $data["color"];
        $newRegister->id_company = $data['id_company'];
        $newRegister->save();

        if($newRegister->id_status_client > 0){
            $res["message"] = "Estatus guardado correctamente";
        }else{
            $res["error"] = true;
            $res["message"] = "Error al guardar el registro";
        }
        return $res;
    }
    public function _update($data)
    {
        $res["error"] = false;

        $updateRegister = $this->find($data['id_status_client']);

        if($updateRegister->count() > 0)
        {
            $updateRegister->name_status = $data['name_status'];
            $updateRegister->description_status = $data['description_status'];
            $updateRegister->orden = $data['orden'];
            $updateRegister->color = $data["color"];
            $updateRegister->save();
            $res["message"] = "Se actualizo el registro correctamente";
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
        if($register->count() > 0 ){
            $register->delete();
            $res["message"] = "Se elimino el registro con éxito";
        }else{
            $res["error"] = true;
            $res["message"] = "No se encontro ningun registro";
        }
        return $res;
    }
    public function _getStatusClient($data)
    {
        $res["error"] = false;
        $res["data"] = "";

        $statusClient = $this->where('id_company', $data["id_company"])->orderBy('orden')->get();

        if($statusClient->count() > 0 ){
            $res["message"] = "success";
            $res["data"] = $statusClient;
        }else{
            $res["error"] = true;
            $res["message"] = "No se encontro ningun registro";
        }
        return $res;
    }
}
