<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalePlan extends Model
{
    use HasFactory;

    protected $table = 'tbl_sale_plan';

    protected $primaryKey = 'id_sale_plan';

    public $timestamps = false;

    public function _logSavePlan($data)
    {
        $plan = new SalePlan;

        $plan->id_plan = $data['id_plan'];
        $plan->id_company = $data['id_company'];
        $plan->name_company = $data['name_company'];
        $plan->date_start = $data['date_start'];
        $plan->date_end = $data['date_end'];
        $plan->time_month = $data['time_month'];
        $plan->option_pay = $data['option_pay'];
        $plan->amount = $data['amount'];
        $plan->number_user = $data['number_user'];
        $plan->amount_extra = $data['amount_extra'];
        $plan->total = $data['total'];
        $plan->sale = 0;

        $plan->save();

        return "success";
    }
    public function _getEraserPlan()
    {
        return $this->where('sale', 0)->get();
    }
    public function _deleteSale($id)
    {
        $delete = $this->find($id)->delete();

        return "success";

    }
}
