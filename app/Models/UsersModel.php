<?php

namespace App\Models;

use CodeIgniter\Model;


class UsersModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'Users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['name','username','password','birthdate'];

    public function Register($data){
        $salt="Cf1f11ePArKlBJomM0F6aJ";
        $custo="08";
        $hashpassword=crypt($data['password'],'$2a$' . $custo . '$' . $salt . '$');
        $tratdata=[
            'username'=>$data['username'],
            'name'=>$data['name'],
            'birthdate'=>$data['birthdate'],
            'password'=>$hashpassword,
        ];
        return $this->insert($tratdata);
    }
    public function Login($data){
        $username=$data['username'];
        $password=$data['password'];
        $userData=$this->where(['username'=>$username])->find();
        if(count($userData)==0) return false;
        else{
            $hashpassword=$userData[0]["password"];
            $verify_hash=crypt($password,$hashpassword);
            if($verify_hash===$hashpassword){
                unset($userData[0]['password']);
                return $userData[0];
            } else{
                return false;
            }
        }
    }
}
