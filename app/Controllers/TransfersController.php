<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccountsModel;
use App\Models\TransfersModel;


class TransfersController extends BaseController
{
    public function createTransfer()
    {
        $toAccId=$this->request->getVar('to');
        $fromAccId=$this->request->getVar('from');
        $transferValue=$this->request->getVar('value');
        
        if(!empty($toAccId)&&!empty($fromAccId)&&!empty($transferValue)){
            $transferType='normal';
            $transferDesc='normal transfer';
            $accModel=new AccountsModel();
            $verifyBalance=$accModel->verifyBalanceSubstractionFromAccount($fromAccId,$transferValue);
            $verifyToAccountIsCurrent=$accModel->AccountIsCurrentType($toAccId);
            if($verifyBalance&&$verifyToAccountIsCurrent){
                $transferModel=new TransfersModel();
                $transferId=$transferModel->makeTransferTo($fromAccId,$toAccId,$transferType,$transferDesc,$transferValue);
                if($transferId){
                    $accModel->removeFromAccount($fromAccId,$transferValue);
                    $accModel->addToAccount($toAccId,$transferValue);
                    $this->session->setFlashdata('sucess','Transação finalizada');
                    return redirect()->to(base_url('/users/'));
                } else{
                    $this->session->setFlashdata('error','Transação não finalizada');
                    return redirect()->to(base_url('/users/'));
                }
            } else{
                $this->session->setFlashdata('error','Saldo Insuficiente ou Conta inválidade');
                return redirect()->to(base_url('/users/'));
            }
        } else{
            $this->session->setFlashdata('error','Valores inválidos');
            return redirect()->to(base_url('/users/'));
        }
    }
    public function createPayment()
    {
        $fromAccId=$this->request->getVar('from');
        $transferValue=$this->request->getVar('value');
        $transferType=$this->request->getVar('type');
        
        if(!empty($transferType)&&!empty($fromAccId)&&!empty($transferValue)){
            $transferDesc='Payment';
            $accModel=new AccountsModel();
            $verifyBalance=$accModel->verifyBalanceSubstractionFromAccount($fromAccId,$transferValue);
            if($verifyBalance){
                $transferModel=new TransfersModel();
                $transferId=$transferModel->makePayment($fromAccId,$transferType,$transferDesc,$transferValue);
                if($transferId){
                    $accModel->removeFromAccount($fromAccId,$transferValue);
                    $accModel->addToAccount(1,$transferValue);
                    $this->session->setFlashdata('sucess','Pagamento realizado');
                    return redirect()->to(base_url('/users/'));
                } else{
                    $this->session->setFlashdata('error','Pagamento não concluido');
                    return redirect()->to(base_url('/users/'));
                }
            } else{
                $this->session->setFlashdata('error','Saldo Insuficiente');
                return redirect()->to(base_url('/users/'));
            }
        } else{
            $this->session->setFlashdata('error','Valores inválidos');
            return redirect()->to(base_url('/users/'));
        }
    }

    public function requireMoney()
    {
        $fromAccId=$this->request->getVar('from');
        $transferValue=$this->request->getVar('value');
        if(!empty($fromAccId)&&!empty($transferValue)){
            $transferType='special payment';
            $transferDesc='Payment';
            $accModel=new AccountsModel();
                $transferModel=new TransfersModel();
                $transferId=$transferModel->receivePaymentFromBank($fromAccId,$transferType,$transferDesc,$transferValue);
                if($transferId){
                    //don't remove money from root bank account
                    $accModel->addToAccount($fromAccId,$transferValue);
                    $this->session->setFlashdata('sucess','Pagamento Recebido');
                    return redirect()->to(base_url('/users/'));
                } else{
                    $this->session->setFlashdata('error','Um erro ocorreu');
                    return redirect()->to(base_url('/users/'));
                }
        } else{
            $this->session->setFlashdata('error','Valores inválidos');
            return redirect()->to(base_url('/users/'));
        }
    
        //$accModel->addToAccount($fromAccId,$transferValue);

    }
    public function rescueFromSavingAccount()
    {
        $accModel=new AccountsModel();

        $toAccId=$this->request->getVar('to');
        $fromAccId=$this->request->getVar('from');
        $transferValue=$this->request->getVar('value');
        $transferType='rescue';
        $transferDesc='rescue from saving account';
        $verifyBalance=$accModel->verifyBalanceSubstractionFromAccount($fromAccId,$transferValue);
        $verifyToAccountIsCurrent=$accModel->AccountIsCurrentType($toAccId);

        if($verifyBalance&&$verifyToAccountIsCurrent){
            $transferModel=new TransfersModel();
            $transferId=$transferModel->makeTransferTo($fromAccId,$toAccId,$transferType,$transferDesc,$transferValue);
            if($transferId){
                $accModel->removeFromAccount($fromAccId,$transferValue);
                $accModel->addToAccount($toAccId,$transferValue);
                $this->session->setFlashdata('sucess','Transação finalizada');
                return redirect()->to(base_url('/users/'));
            } else{
                $this->session->setFlashdata('error','Transação não finalizada');
                return redirect()->to(base_url('/users/'));
            }
        } else{
            $this->session->setFlashdata('error','Saldo Insuficiente ou Conta inválidade');
            return redirect()->to(base_url('/users/'));
        }

    }
    public function ApplyToSavingAccount()
    {
        $accModel=new AccountsModel();

        $toAccId=$this->request->getVar('to');
        $fromAccId=$this->request->getVar('from');
        $transferValue=$this->request->getVar('value');
        $transferType="Apply";
        $transferDesc='Apply to Saving Account';
        $verifyBalance=$accModel->verifyBalanceSubstractionFromAccount($fromAccId,$transferValue);
        $verifyToAccountIsCurrent=$accModel->AccountIsCurrentType($fromAccId);
        if($verifyBalance&&$verifyToAccountIsCurrent){
            $transferModel=new TransfersModel();
            $transferId=$transferModel->makeTransferTo($fromAccId,$toAccId,$transferType,$transferDesc,$transferValue);
            if($transferId){
                $accModel->removeFromAccount($fromAccId,$transferValue);
                $accModel->addToAccount($toAccId,$transferValue);
                $this->session->setFlashdata('sucess','Transação finalizada');
                return redirect()->to(base_url('/users/'));
            } else{
                $this->session->setFlashdata('error','Transação não finalizada');
                return redirect()->to(base_url('/users/'));
            }
        } else{
            $this->session->setFlashdata('error','Saldo Insuficiente ou Conta inválidade');
            return redirect()->to(base_url('/users/'));
        }
    }

}
