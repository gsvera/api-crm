<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\PlanDetail;

class Plan extends Model
{
    use HasFactory;

    protected $table = 'tbl_plan';

    protected $primaryKey = 'id_plan';

    public $timestamps = false;

    public function detail()
    {
        return $this->hasMany('App\Models\PlanDetail', 'id_plan');
    }

    public function _store($data)
    {
        $newPlan = new Plan;
        $newPlan->name_plan = $data['name_plan'];
        $newPlan->months = (int)$data['months'];
        $newPlan->visible = $data['visible'];
        $newPlan->number_user = $data['number_user'];
        $newPlan->price_month = (float)$data['price_months'];
        $newPlan->price_year = (float)$data['price_year'];
        $newPlan->created_at = date('Y-m-d H:i:s');
        $newPlan->update_at = date('Y-m-d H:i:s');
        $newPlan->save();

        if($data['detailPlan'] != null && count($data['detailPlan']) > 0){
            foreach($data['detailPlan'] as $item){
                $valueDetail = [
                    'id_plan' => $newPlan->id_plan,
                    'descript_detail' => $data['descript_detail']
                ];

                $newDetail = new PlanDetail;
                $newDetail->_storeDetail($valueDetail);

            }
        }
        return "success";
    }
    public function _getPlans()
    {        
        $query = $this->with(array('detail' => function($query){
            $query->select('tbl_plan_detail.*');
        }))
        ->get();

        return $query;
    }
    public function _updatePlan($data)
    {
        $plan = $this->find($data['id_plan']);

        $plan->name_plan = $data['name_plan'];
        $plan->months = (int)$data['months'];
        $plan->visible = $data['visible'];
        $plan->number_user = $data['number_user'];
        $plan->price_month = (float)$data['price_months'];
        $plan->price_year = (float)$data['price_year'];
        $plan->update_at = date('Y-m-d H:i:s');
        $plan->save();

        $detail = PlanDetail::where('id_plan', $data['id_plan'])->delete();

        if($data['detailPlan'] != null && count($data['detailPlan']) > 0){
            foreach($data['detailPlan'] as $item){
                $valueDetail = [
                    'id_plan' => $data['id_plan'],
                    'descript_detail' => $item['descript_detail']
                ];

                $newDetail = new PlanDetail;
                $newDetail->_storeDetail($valueDetail);
            }
        }

        return "success";

    }
}
