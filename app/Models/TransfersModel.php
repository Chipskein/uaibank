<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\AccountsModel;
class TransfersModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'Transfers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['type','from','to','description','transfer_date','value'];
    private $paymentAccountId    = 1;

    public function getTransfersByUser($userId=null)
    {
        $accIds=[];
        $accModel=new AccountsModel();
        $accQuery=$accModel->getAccountsIdByUser($userId);
        foreach($accQuery as $row){
            array_push($accIds,$row['id']);
        }
        return $this->whereIn('from',$accIds)->orWhereIn('to',$accIds)->findAll();
    }

    public function makePayment($accId,$type,$desc,$value)
    {
        //insert into Transfers to $paymentAccount
    }
    public function makeTransferTo($accId,$toaccId,$type,$desc,$value)
    {
        //insert into Transfers to $toaccId
    }
}

