<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccountsModel;
use App\Models\TransfersModel;
use App\Models\UsersModel;
use App\Models\UsersSessionsModel;
use DateTime;
class UsersController extends BaseController
{
    private $expire=3600;//seconds(1hour);
    public function showLoginForm()
    {
        $session=session();
        if($session->has('id')&&$session->has('username')&&$session->has('name')&&$session->has('birthdate')){
            return redirect()->to(base_url('/users/'));
        }
        else return view('LoginForm');
    }
    public function showHome()
    {
        $session=session();
        if($session->has('id')&&$session->has('username')&&$session->has('name')&&$session->has('birthdate')){
            $userId=$session->get('id');
            $accsmodel=new AccountsModel();
            $transfmodel=new TransfersModel();
            $sessionModel=new UsersSessionsModel();
            $accs=$accsmodel->getAccountsByUser($userId);
            
            $current_acc=count($accs)>0 ? $accs[0]:false;
            $saving_acc= count($accs)>0 ? $accs[1]:false;

            $today=new Datetime();
            $today=$today->format('Y-m-d');
            $lastYeldTransfer = $transfmodel->getSavingAccLastYeld($saving_acc['id']);
            
            $value= count($lastYeldTransfer)>0 ? $lastYeldTransfer[0]['transfer_date']:false;
            $date=new Datetime($value);
            $date=$date->format('Y-m-d');
            
            if($value && $date != $today && $saving_acc['balance']>0){                               
                $yeld = ((6.2/365)*100)/$saving_acc['balance'];
                $transferYeld = $transfmodel->receiveYeldFromBank($saving_acc['id'], $yeld);
                if($transferYeld){
                    $accsmodel->addToAccount($saving_acc['id'],$yeld);
                }
            } else if(count($lastYeldTransfer) == 0 && $saving_acc['balance']>0){
                $yeld = ((6.2/365)*100)/$saving_acc['balance'];
                $transferYeld = $transfmodel->receiveYeldFromBank($saving_acc['id'], $yeld);
                if($transferYeld){
                    $accsmodel->addToAccount($saving_acc['id'],$yeld);
                }
            }          

            $transfers=$transfmodel->getTransfersByUser($userId);
            $lastlogin=$sessionModel->getLastLoginFromUser($userId);

            $savingAccInfo = ["monthYeld" => 0.00, "appliedValue" => 0.00];

            $allApplications = $transfmodel->getAllSavingsApplications($saving_acc['id'], $current_acc['id']);
            $allRescues = $transfmodel->getAllSavingsRescues($saving_acc['id'], $current_acc['id']);
            $savingAccInfo['appliedValue'] = $allApplications['total']-$allRescues['total'];
            $savingAccInfo['monthYeld'] = $transfmodel->getAllSavingsyeld($saving_acc['id'], $current_acc['id'])['total'];

            $data=[
                'accounts'=>$accs,
                'savingAccInfo'=>$savingAccInfo,
                'transfers'=>$transfers,
                'lastLogin'=>$lastlogin,
            ];
            return view('Home',$data);
        }
        else return redirect()->to(base_url('/users/login'));
    }
    public function ShowRegisterForm()
    {
        $session=session();
        if($session->has('username')&&$session->has('name')&&$session->has('birthdate')){
            return redirect()->to(base_url('/users/'));
        }
        else return view('RegisterForm');
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
            $this->session->setFlashdata('error', 'Credenciais inv??lidas');
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
        $session=session();
        if($session->has('id')&&$session->has('username')&&$session->has('name')&&$session->has('birthdate')){
            $logoff_date=new DateTime();
            $logoff_date=$logoff_date->format('Y-m-d H:i:s');
            $data=[
                'logoff_at'=>$logoff_date,
                'logged_at'=>$this->session->get('logged_at'),
                'user'=>$this->session->get('id'),
            ];
            //add to auditoria
            $usmodel=new UsersSessionsModel();
            $usmodel->insertSession($data);
            
            $this->session->destroy();            
            return redirect()->to(base_url('/users/login'));
        } else{
            $this->session->setFlashdata('error', 'N??o est?? logado');
            return redirect()->to(base_url('/users/login'));
        }
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
        if(!$usermodel->verifyIfUserExists($data['username'])){
            $userId=$usermodel->Register($data);
            if($userId){
                $acc_current_data=[
                    'balance'=>$this->request->getVar('balance_current'),
                    'user'=>$userId,
                    'type'=>'current',
                ];
                $acc_saving_data=[
                    'balance'=>0,
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
                    $this->session->setFlashdata('error', 'Falha no cadastro do usu??rio');
                    return redirect()->to(base_url('/users/register'));
                }
            } else {
                $this->session->setFlashdata('error', 'Falha no cadastro do usu??rio');
                return redirect()->to(base_url('/users/register'));
            }
        } else{
            $this->session->setFlashdata('error', 'Usuario ja existe');
            return redirect()->to(base_url('/users/register'));
        }
    }
}
