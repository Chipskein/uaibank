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
        $transferType='normal';
        $transferDesc='normal transfer';
        $accModel=new AccountsModel();
        $verifyBalance=$accModel->verifyBalanceSubstractionFromAccount($fromAccId,$transferValue);
        if($verifyBalance){
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
            $this->session->setFlashdata('error','Saldo Insuficiente');
            return redirect()->to(base_url('/users/'));
        }
    }
}
