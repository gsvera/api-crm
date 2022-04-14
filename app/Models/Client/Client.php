<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Folio\Folio;
use App\Models\Client\DetailContact;
use App\Models\Client\LogContact;

class Client extends Model
{
    use HasFactory;
    protected $table = 'crm_client';
    protected $primaryKey = 'id_client';
    public $timestamps = false;
    public $detalleContacto = [];

    public function _detailContact()
    {
        return $this->hasMany(DetailContact::class, 'id_client');
    }
    public function _detailLogContact()
    {
        return $this->hasMany(LogContact::class, 'id_client');
    }
    public function _store($data)
    {
        $detailContact = new DetailContact;
        $folio = new Folio;
        $cont = $folio->_folio("CRM", "Cliente", $data['id_company']);
        $register = new Client;
        $register->folio_client = $cont;
        $register->first_name = $data['first_name'];
        $register->last_name = $data['last_name'];
        $register->birth_day = $data['birth_day'];
        $register->adress = $data['adress'];
        $register->id_user_create = $data['id_user'];
        $register->id_company = $data['id_company'];
        $register->date_create = date('Y-m-d H:i:s');
        $register->save();

        foreach($data["detailContact"] as $element)
        {
            $detailContact->_store($register->id_client, $element);
        }

        return "Cliente creado con exito";
    }
    public function _update($data)
    {
        $detailContact = new DetailContact;

        $register = $this->find($data['id_client']);
        $register->first_name = $data['first_name'];
        $register->last_name = $data['last_name'];
        $register->birth_day = $data['birth_day'];
        $register->adress = $data['adress'];
        $register->id_user_update = $data['id_user'];
        $register->date_update = date('Y-m-d H:i:s');
        $register->save();

        $detailContact->_cleanDetail($data['id_client']);

        foreach($data["detailContact"] as $element)
        {
            $detailContact->_store($register->id_client, $element);
        }

        return "Registro actualizado correctamente";
    }
    public function _getClientXCompany($id_company)
    {
        $registers = $this->with(array('_detailContact' => function($registers){
                            $registers->select("*");
                        }))
                        ->where('id_company', $id_company)
                        ->select('id_client','folio_client','first_name', 'last_name','birth_day', 'adress','enabled')
                        ->get();

        return $registers;
    }
    public function _clientsActive($idCompany)
    {
        $registers = $this->with(array('_detailContact' => function($registers){
            $registers->select("*");
        }))
        ->where('id_company', $idCompany)
        ->where('enabled', true)
        ->select('id_client','folio_client','first_name', 'last_name','birth_day', 'adress','enabled')
        ->get();

        return $registers;
    }
    public function _clientById($idClient)
    {
        $client = $this->with(array('_detailContact' => function($registers){
            $registers->select("*");
        }))
        ->with(array('_detailLogContact' => function($registers){
            $registers->select("*");
        }))
        ->select("id_client", "folio_client", "first_name", "last_name", "birth_day", "adress")->find($idClient);

        return $client;
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
