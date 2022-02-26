<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use App\Models\Company;

class Login extends Model
{
    use HasFactory;

    protected $phrase = 'Y38oB6mTB34wd1M7memoT5U34533A54QiK1X538Iy048840d3yAfJr354n7g33M8o9151B853TVP51K3r6o2q60633H1tq4a5';

    public function protectedPass($data)
    {
        return base64_encode($this->phrase.base64_encode(str_rot13(serialize($data))));
    }
    public function unProtected($data){
        try{
            $decrypData = base64_decode($data);
            $decrypData = str_replace($this->phrase, "", $decrypData);
            $decrypData = unserialize(str_rot13(base64_decode($decrypData)));
            return $decrypData;

        }catch(Exception $e){
            return false;
        }
    }
    public function login($email, $password)
    {
        $resp = [];
        $user = Usuario::where('email', $email)
                        ->first();
        
        if($user['active'] != 1){
            $res['success'] = false;
            $res['message'] = "Usuario inactivo comuniquese a soporte";

            return $res;
        }
        if(Hash::check($password, $user->password)){

            $token = $this->protectedPass($password);
            $user->token = $token;
            $user->save();
            $res['success'] = true;
            $res['token'] = $token;
            $res['name_user'] = $user->name;
            $res['id_user'] = $user->id;
            $res['success'] = true;
            $res['data_company'] = 0;

            $company = new Company;
            $dataCompany = $company->where('id_user_admin', $user->id)->select('id_company','name_company', 'rfc', 'active')->first();

            if($dataCompany != null){
                if($dataCompany->active == 0){
                    $res['message'] = "La empresa no se encuentra habilitada";
                    $res['success'] = false;
                    return $res;
                }
                if($dataCompany->count() > 0){
                    $res['data_company'] = $dataCompany;
                }
            }
            
            return $res;
        }else{
            $res['success'] = false;
            $res['message'] = "Usuario o contraseña incorrecta";
            return $res;
        }
    }
    public function loginPanel($email, $password)
    {
        $user = Usuario::where('email', $email)
                        ->first();

        if($user->user_panel == 1 && $user->active == 1){
            $res = $this->login($email, $password);
            return $res;
        }else{
            $res['success'] = false;
            return $res;
        }
    }
}
