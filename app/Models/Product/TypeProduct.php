<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeProduct extends Model
{
    use HasFactory;

    protected $table = "crm_tipo_product";
    protected $primaryKey = "id_tipo_product";
    public $timestamps = false;

    public function _store($data)
    {
        $res["error"] = false;

        if($data["id_company"] == null)
        {
            $res["error"] = true;
            $res["message"] = "El id de la compañia es obligatorio";
        }
        else
        {
            $newRegister = new TypeProduct();
            $newRegister->name_tipo = $data["name_tipo"];
            $newRegister->id_company = $data["id_company"];
            $newRegister->save();

            $res["message"] = "Registro guardado con exito";
        }
        return $res;
    }
    public function _getTypeProduct($id_company)
    {
        $res["error"] = false;
        $res["message"] = "";
        $data = $this->where('id_company', $id_company)->get();

        if($data != null)
        {
            $res["data"] = $data;
        }
        else
        {
            $res["error"] = true;
            $res["message"] = "No se encontro ningun registro";            
        }
        return $res;
    }
    public function _update($data)
    {
        $res["error"] = false;

        $register = $this->find($data["id_tipo_product"]);

        if($register->count() > 0)
        {
            $register->name_tipo = $data["name_tipo"];
            $register->save();
            $res["message"] = "Registro actualizado correctamente";
        }
        else
        {
            $res["error"] = true;
            $res["message"] = "No se encontro el registro";
        }
        return $res;
    }
    public function _delete($id_product)
    {
        $res["error"] = false;

        $register = $this->find($id_product);

        if($register->count() > 0)
        {
            $register->delete();
            $res["message"] = "Registro borrado con éxito";
        }
        else
        {
            $res["error"] = true;
            $res["message"] = "No se encontro el registro";
        }

        return $res;
    }
}
