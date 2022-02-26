<?php

namespace App\Models\Folio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FolioModulo;
use App\Models\Respuesta;

class Folio extends Model
{
    use HasFactory;

    protected $table = 'crm_folio';
    protected $primaryKey = 'id_folio';
    public $timestamps = false;
 
    public function _newFoliosCompany($id_company)
    {
        $getModules = new FolioModulo;
        $modules = $getModules->_modulesCRM();
        foreach($modules as $key => $value)
        {
            $folio = new Folio;
            $folio->count = 0;
            $folio->folio = $value->folio;
            $folio->modulo = $value->modulo;
            $folio->sub_modulo = $value->sub_modulo;
            $folio->id_company = $id_company;
            $folio->save();
        }
    }
    public function getFoliosCompany($id_company)
    {
        $register = $this->where('id_company', $id_company)->get();

        return $register;
    }
    public function _updateFolio($data)
    {
        $res = new Respuesta;

        $folio = $this->find($data['id_folio']);

        if($folio->count >= $data["count"] && $folio->folio == $data["folio"])
        {
            $res->error = true;
            $res->message = "El folio no puede ser menor o igual que el actual.";
        }
        else
        {
            $folio->count = $data["count"];
            $folio->folio = $data["folio"];
            $folio->save();

            $res->message = "Folio actualizado correctamente";
        }
        return $res;
    }
}
