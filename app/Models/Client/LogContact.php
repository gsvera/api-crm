<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogContact extends Model
{
    use HasFactory;
    protected $table = 'crm_log_contact';
    protected $primaryKey = 'id_log_contact';
    public $timestamps = false;

    public function _store($data)
    {
        $register = new LogContact;
        $register->status_client = $data["status_client"];
        $register->id_task = isset($data["id_task"]) ? $data["id_task"] : 0;
        $register->id_client = $data["id_client"];
        $register->option_contact = $data["option_contact"];
        $register->data_contact = $data["data_contact"];
        $register->name_contact = $data["name_contact"];
        $register->comment_contact = $data["comment_contact"];
        $register->id_user_contact = $data["id_user"];
        $register->user_contact = $data["user_contact"];
        $register->date_contact = $data["date_contact"];
        $register->time_contact = $data["time_contact"];
        $register->id_company = $data["id_company"];
        $register->save();

        return "Registro guardado con éxito";
    }
    public function _getByClient($idClient)
    {
        $registers = $this->where('id_client', $idClient)->get();
        return $registers;
    }
}
