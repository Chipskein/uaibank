<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\AccountsModel;
use DateTime;

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
    
    
    private $paymentAccountId    = 1;//account that send internal bank tranfers
        
    
    public function getTransfersByUser($userId=null)
    {
        $accIds=[];
        $accModel=new AccountsModel();
        $accQuery=$accModel->getAccountsIdByUser($userId);
        foreach($accQuery as $row){
            array_push($accIds,$row['id']);
        }
        return $this
                ->select("Transfers.*,u.name")
                ->join('Accounts a','Transfers.from=a.id')
                ->join('Users u','a.user=u.id')
                ->whereIn('Transfers.from',$accIds)
                ->orWhereIn('Transfers.to',$accIds)
                ->orderBy('Transfers.transfer_date','desc')
                ->findAll();
    }

    public function makePayment($accId,$type,$desc,$value)
    {
        //insert into Transfers to $paymentAccount
        $datetime=new DateTime();
        $datetime=$datetime->format('Y-m-d H:i:s');
        $data=[
            'from'=>$accId,
            'to'=>$this->paymentAccountId,
            'type'=>$type,
            'desc'=>$desc,
            'value'=>$value,
            'transfer_date'=>$datetime
        ];
        return $this->insert($data);
    }
    public function makeTransferTo($accId,$toaccId,$type,$desc,$value)
    {
        $datetime=new DateTime();
        $datetime=$datetime->format('Y-m-d H:i:s');
        $data=[
            'from'=>$accId,
            'to'=>$toaccId,
            'type'=>$type,
            'description'=>$desc,
            'value'=>$value,
            'transfer_date'=>$datetime
        ];
        return $this->insert($data);
    }

    public function receivePaymentFromBank($accId,$type,$desc,$value)
    {
        $datetime=new DateTime();
        $datetime=$datetime->format('Y-m-d H:i:s');
        $data=[
            'from'=>$this->paymentAccountId,
            'to'=>$accId,
            'type'=>$type,
            'desc'=>$desc,
            'value'=>$value,
            'transfer_date'=>$datetime
        ];
        return $this->insert($data);
    }
    public function getSavingAccLastTransaction($SaveAccId, $CrtAccId)
    {
        $data=[
            'from'=>$CrtAccId,
            'to'=>$SaveAccId,
        ];
        return $this->where($data)->orderBy('transfer_date','desc')->limit(1)->findAll();
    }
    public function getSavingAccLastYeld($SaveAccId)
    {
        $data=[
            'from'=>$this->paymentAccountId,
            'to'=>$SaveAccId,
            'type'=>'yeld'
        ];
        
        return $this->where($data)->orderBy('transfer_date','desc')->limit(1)->find();
    }
    public function receiveYeldFromBank($accId,$value)
    {
        $datetime=new DateTime();
        $datetime=$datetime->format('Y-m-d H:i:s');
        $data=[
            'from'=>$this->paymentAccountId,
            'to'=>$accId,
            'type'=>'yeld',
            'desc'=>'Saving account yeld',
            'value'=>$value,
            'transfer_date'=>$datetime
        ];
        return $this->insert($data);
    }
}

