<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanDetail extends Model
{
    use HasFactory;

    protected $table = 'tbl_plan_detail';

    protected $primaryKey = 'id_detail_plan';

    public $timestamps = false;

    public function _storeDetail($data)
    {
        $detail = new PlanDetail;
        $detail->id_plan = $data['id_plan'];
        $detail->description_plan = $data['descript_detail'];
        $detail->save();
    }
}
