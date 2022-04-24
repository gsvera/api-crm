<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company_X_Usuario extends Model
{
    use HasFactory;

    protected $table = 'tbl_company_usuario';
    protected $primaryKey = 'id_pivote';

    public $timestamps = false;

    public function _store($data)
    {
        $register = new Company_X_Usuario;
        $register->id_company = $data["id_company"];
        $register->id_usuario = $data["id_user"];
        $register->save();

        return "Se guardo el registro correctamente";
    }
    public function _getData($idCompany)
    {
        $registers = $this->leftJoin('users as u', 'tbl_company_usuario.id_usuario', 'u.id')
                        ->select('tbl_company_usuario.*', 'u.name', 'u.email')
                        ->where('id_company', $idCompany)
                        ->get();
        
        return $registers;
    }
    public function _deleteRelathion($idPivot)
    {
        $register = $this->find($idPivot);
        $register->delete();

        return "Se borro el registro con éxito";
    }
}
