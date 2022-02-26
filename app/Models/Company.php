<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company_X_Usuario;
use App\Models\Folio\Folio;
use App\Models\FolioModulo;

class Company extends Model
{
    use HasFactory;

    protected $table = 'tbl_company';

    protected $primaryKey = 'id_company';

    public $timestamps = false;

    public function _newCompany($data)
    {
        $getExist = $this->where('rfc', $data['rfc'])->first();
        if($getExist != null){
            $res['success']  = false;
            $res['message'] = "Ya existe una empresa con ese RFC";
            return $res;
        }
        $newCompany = new Company;
        $newCompany->name_company = $data['name_company'];
        $newCompany->rfc = $data["rfc"];
        $newCompany->number_user = (int)$data['number_user'];
        $newCompany->active = $data['active'];
        $newCompany->created_at = date('Y-m-d H:i:s');
        $newCompany->id_user_admin = $data['id_user_admin'];
        $newCompany->save();

        $tableCom_user = new Company_X_Usuario;
        $tableCom_user->id_company = $newCompany->id_company;
        $tableCom_user->id_usuario = $data['id_user_admin'];
        $tableCom_user->save();

        $newFolios = new Folio();
        $newFolios->_newFoliosCompany($newCompany->id_company);

        $res['success'] = "success";
        
        return $res;
    }
    public function _allCompanys()
    {
        $companys = $this->leftJoin('users', 'tbl_company.id_user_admin', 'users.id')
                    ->select('tbl_company.*', 'users.name as name_user_admin', 'users.email')
                    ->get();

        return $companys;
    }
    public function _deleteCompany($idCompany)
    {
        $delCompanyUsuario = new Company_X_Usuario;
        $delCompanyUsuario->where('id_company',$idCompany)->delete();

        $delCompany = $this->find($idCompany)->delete();

        return "success";
    }
    public function _updateCompany($data)
    {
        $res['error'] = false;

        $consult = $this->where("rfc", $data['rfc'])
                    ->where('id_company', '!=', $data['id_company'])
                    ->get();

        if($consult->count() > 0){
            $res['error'] = true;
            $res["message"] = "Ya existe una empresa con ese RFC";
            return $res;
        }

        $company = $this->find($data['id_company']);
        if($company == null || $company == ''){
            $res["message"] = "No se encontro la empresa";
            $res['error'] = true;
            return $res;
        }




        //PENDIENTE ACTUALIZAR EL USUARIO ADMIN




        $relation = new Company_X_Usuario;
        $relation->where('id_company', $data['id_company'])->get();
        
        if($company['number_user'] < $relation->count()){
            $res["message"] = "El numero de usuarios no puede ser menor a los existentes";
            $res['error'] = true;
            return $res;
        }
        $company->name_company = $data['name_company'];
        $company->rfc = $data['rfc'];
        $company->number_user = $data['number_user'];
        $company->active = $data['active'];
        $company->id_user_admin = $data['id_user_admin'];
        $company->update_at = date('Y-m-d H:i:s');
        $company->save();

        return $res;
    }
}
