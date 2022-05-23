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
}
