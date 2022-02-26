<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = ['email', 'password'];

    public $timestamps = false;

    private $validations = [
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|string',
        'password' => 'required|string',
        'active' => 'required|boolean',
        'enviroment' => 'required|string',
        'user_panel' => 'required|boolean'
    ];

    public $customerMessageError = [
        'first_name.required' => 'El campo primer nombre es obligatorio',
        'last_name.required' => 'El campo primer apellido es obligatorio',
        'email.required' => 'El campo email es obligatorio',
        'password.required' => 'El campo contraseña es obligatoria',
        'active.required' => 'El campo activo es obligatorio',
        'ambiente.required' => 'El campo ambiente es obligatorio',
        'user_panel.required' => 'El campo panel es obligatorio'
    ];

    public function newUser($data)
    {
        $resp = "success";
        $validator = Validator::make($data, $this->validations, $this->customerMessageError);
        if($validator->fails()){
            $validatorErrors = [$validator->errors()->getMessageBag()];
            return $validatorErrors;
        }

        $getUser = $this->where('email', $data['email'])->first();
        if($getUser != null){
            $resp = "error";
            return $resp;
        }
        
        $new_user = new User;
        $new_user->name = $data['first_name'] . ' ' . $data['last_name'];
        $new_user->first_name = $data['first_name'];
        $new_user->last_name = $data['last_name'];
        $new_user->email = $data['email'];
        $new_user->password = Hash::make($data['password']);
        $new_user->active = $data['active'];
        $new_user->enviroment = $data['enviroment'];
        $new_user->user_panel = $data['user_panel'];
        $new_user->save();
        return $new_user;
    }
    public function deleteUser($id_user)
    {
        $resp = $this->where('id', $id_user)->first();
        if($resp == null){
            return 'error';
        }
        $resp->delete();
        return "borrado";
    }
    public function getUserById($id)
    {
        $getUser = $this->where('id', $id)->first();
        
        return $getUser;
    }
    public function updateUser($data)
    {
        $user = $this->find($data['id_user']);
        
        if($user == null || $user == ""){
            return "error";
        }

        $user->name = $data['first_name'] . ' ' . $data['last_name'];
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        if($data['password'] != '' || $data['password'] != null){
            $user->password = Hash::make($data['password']);
        }
        $user->updated_at = date('Y-m-d H:i:s');
        $user->active = $data['active'];
        $user->enviroment = $data['enviroment'];
        $user->user_panel = $data['user_panel'];
        $user->save();

        return "success";
    }
}
