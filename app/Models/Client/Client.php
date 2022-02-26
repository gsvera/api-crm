<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'crm_client';
    protected $primaryKey = 'id_client';
    public $timestamps = false;

    public function _store($data)
    {
        $register = new Client;
        $register->first_name = $data['first_name'];
        $register->last_name = $data['last_name'];
        $register->email = $data['email'];
        $register->phone_number = $data['phone_number'];
        $register->whatsapp_number = $data['whatsapp_number']==null?0:$data['whatsapp_number'];
        $register->birth_day = $data['birth_day'];
        $register->adress = $data['adress'];
        $register->id_user_create = $data['id_user'];
        $register->id_company = $data['id_company'];
        $register->date_create = date('Y-m-d H:i:s');
        $register->save();

        return "Cliente creado con exito";
    }
    public function _update($data)
    {
        $register = $this->find($data['id_client']);
        $register->first_name = $data['first_name'];
        $register->last_name = $data['last_name'];
        $register->email = $data['email'];
        $register->phone_number = $data['phone_number'];
        $register->whatsapp_number = $data['whatsapp_number']==null?0:$data['whatsapp_number'];
        $register->birth_day = $data['birth_day'];
        $register->adress = $data['adress'];
        $register->id_user_update = $data['id_user'];
        $register->date_update = date('Y-m-d H:i:s');
        $register->save();

        return "Registro actualizado correctamente";
    }
    public function _getClientXCompany($id_company)
    {
        $registers = $this->where('id_company', $id_company)
                        ->select('id_client','first_name', 'last_name','email','phone_number','whatsapp_number','birth_day', 'adress','enabled')
                        ->get();

        return $registers;
    }
    public function _disabled($data)
    {
        $client = $this->find($data['id_client']);
        $client->enabled = $data['enabled']==true?1:0;
        $client->save();

        $status = ['enabled' => $client->enabled];

        return $status;
    }
    public function _delete($id_client)
    {
        $clientDelete = $this->find($id_client);
        if($clientDelete->count() > 0)
        {
            $clientDelete->delete();
            return "Registro eliminado correctamente.";
        }
        else
        {
            return "Registro no encontrado";
        }
    }
}
