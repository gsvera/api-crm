<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailContact extends Model
{
    use HasFactory;
    protected $table = 'crm_detail_contac_client';
    protected $primaryKey = 'id_detail';
    public $timestamps = false;

    public function _store($idClient, $data)
    {
        $register = new DetailContact;
        $register->id_client = $idClient;
        $register->form_contact = $data["form_contact"];
        $register->name_contact = $data["name_contact"];
        $register-> data_contact = $data["data_contact"];
        $register->save();
    }
    public function _cleanDetail($idClient)
    {
        $registers = $this->where('id_client', $idClient)->get();
        foreach($registers as $item)
        {
            $item->delete();
        }
    }
}
