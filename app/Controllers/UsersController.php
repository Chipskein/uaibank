<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccountsModel;
use App\Models\UsersModel;
use DateTime;
class UsersController extends BaseController
{
    private $expire=3600;//seconds(1hour);

    public function showLoginForm()
    {
        return view('LoginForm');
    }
    public function showHome()
    {
        return view('Home');
    }
    public function Login()
    {
        $data=[
            'username'=>$this->request->getVar('username'),
            'password'=>$this->request->getVar('password'),
        ];
        $userModel=new UsersModel();
        $user=$userModel->Login($data);
        if(!$user){
            $this->session->setFlashdata('error', 'Não foi possivel Logar Usuario :(');
            return redirect()->to(base_url('/users/login'));
        } else{
            $datetime=new DateTime();
            $datetime=$datetime->format('Y-m-d H:i:s');
            $user['logged_at']=$datetime;
            $this->session->setTempdata($user,null,$this->expire);
            return redirect()->to(base_url('/users/'));
        }
    }
    public function Logoff()
    {
        $logoff_date=new DateTime();
        $logoff_date=$logoff_date->format('Y-m-d H:i:s');
        
        $data=[
            'logoff_at'=>$logoff_date,
            'logged_at'=>$this->session->get('logged_at'),
            'username'=>$this->session->get('username'),
            'password'=>$this->session->get('password'),
        ];
        
        //add to auditoria
        $this->session->destroy();
        //to login after
        return redirect()->to(base_url('/users/'));
    }

    public function ShowRegisterForm()
    {
        return view('RegisterForm');
    }
    public function Register()
    {
        $data=[
            'username'=>$this->request->getVar('username'),
            'name'=>$this->request->getVar('name'),
            'birthdate'=>$this->request->getVar('birthdate'),
            'password'=>$this->request->getVar('password'),
        ];
        $usermodel=new UsersModel();
        $userId=$usermodel->Register($data);
        if($userId){
            //create bankaccount
            $acc_data=[
                'balance'=>$this->request->getVar('balance'),
                'user'=>$userId,
                'type'=>$this->request->getVar('account_type'),
            ];
            $accModel=new AccountsModel();
            $accId=$accModel->createAccount($acc_data);
            if($accId){
                $datetime=new DateTime();
                $datetime=$datetime->format('Y-m-d H:i:s');
                $user=[
                    'id'=>$userId,
                    'username'=>$data['username'],
                    'name'=>$data['name'],
                    'birthdate'=>$data['birthdate'],
                    'logged_at'=>$datetime,
                ];
                $this->session->setTempdata($user,null,$this->expire);
                return redirect()->to(base_url('/users/'));
            }
            else {
                //delete user
                $this->session->setFlashdata('error', 'Não foi possivel cadastrar Usuario :(');
                return redirect()->to(base_url('/users/register'));
            }
        } else {
            $this->session->setFlashdata('error', 'Não foi possivel cadastrar Usuario :(');
            return redirect()->to(base_url('/users/register'));
        }
    }
}
