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
        $birthdate=strtotime($this->request->getVar('birthdate'));
        $birthdate=date('Y-m-d',$birthdate);
        $data=[
            'username'=>$this->request->getVar('username'),
            'name'=>$this->request->getVar('name'),
            'birthdate'=>$birthdate,
            'password'=>$this->request->getVar('password'),
        ];
        $usermodel=new UsersModel();
        $userId=$usermodel->Register($data);
        if($userId){
            $acc_current_data=[
                'balance'=>$this->request->getVar('balance_current'),
                'user'=>$userId,
                'type'=>'current',
            ];
            $acc_saving_data=[
                'balance'=>$this->request->getVar('balance_saving'),
                'user'=>$userId,
                'type'=>'saving',
            ];
            $accModel=new AccountsModel();
            $acc_currentId=$accModel->createAccount($acc_current_data);
            $acc_savingId=$accModel->createAccount($acc_saving_data);
            if($acc_currentId&&$acc_savingId){
                $datetime=new DateTime();
                $datetime=$datetime->format('Y-m-d H:i:s');
                $user=[
                    'id'=>$userId,
                    'username'=>$data['username'],
                    'name'=>$data['name'],
                    'birthdate'=>$birthdate,
                    'logged_at'=>$datetime,
                ];
                $this->session->setTempdata($user,null,$this->expire);
                return redirect()->to(base_url('/users/'));
            }
            else {
                $this->session->setFlashdata('error', 'Não foi possivel cadastrar Usuario :(');
                return redirect()->to(base_url('/users/register'));
            }
        } else {
            $this->session->setFlashdata('error', 'Não foi possivel cadastrar Usuario :(');
            return redirect()->to(base_url('/users/register'));
        }
        
    }
}
