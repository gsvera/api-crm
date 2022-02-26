<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FolioModulo extends Model
{
    use HasFactory;
    protected $table = "tbl_folio_modulo";
    protected $primaryKey = "id_folio_modulo";
    public $timestamps = false;

    public function _modulesCRM()
    {
        $register = $this->where('modulo', 'CRM')->get();

        return $register;
    }
}
