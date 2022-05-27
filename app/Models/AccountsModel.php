<?php

namespace App\Models;

use CodeIgniter\Model;

class AccountsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'Accounts';
    protected $primaryKey       = 'id';//should be a composite key codeigniter doesn't support
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    //type => saving or current
    protected $allowedFields    = ['id','user','type','balance'];

    public function createAccount($data)
    {
        return $this->insert($data);
    }
    public function getAccountsByUser($userId)
    {   
        return $this->where(['user'=>$userId])->findAll();
    }
    public function getAccountsIdByUser($userId)
    {
        return $this->select('id')->where(['user'=>$userId])->orderBy('type')->findAll();
    }
    public function verifyBalanceSubstractionFromAccount($accId,$substractionValue)
    {
        $balance=$this->where(['id'=>$accId])->findColumn('balance')[0];
        $operation=$balance-$substractionValue;
        if($operation>=0) return true;
        else return false;
    }
    public function AccountIsCurrentType($accId)
    {
        $query=$this->where(['id'=>$accId])->findColumn('type');
        $type= $query ? $query[0]:false;
        if($type=='current') return true;
        else return false;
    }
    public function removeFromAccount($accId,$value)
    {
        $verifybalance=$this->verifyBalanceSubstractionFromAccount($accId,$value);
        if($verifybalance){
            $currentbalance=$this->where(['id'=>$accId])->findColumn('balance')[0];
            $balance=$currentbalance-$value;
            $data['balance']=$balance;
            $this->update($accId,$data);
        }
    }
    public function addToAccount($accId,$value)
    {   
        $currentbalance=$this->where(['id'=>$accId])->findColumn('balance')[0];
        $balance=$currentbalance+$value;
        $data['balance']=$balance;
        $this->update($accId,$data);
      
    }
}