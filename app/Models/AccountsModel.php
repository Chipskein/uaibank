<?php

namespace App\Models;

use CodeIgniter\Model;

class AccountsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'Accounts';
    protected $primaryKey       = array('id','user','type');
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    //type => saving or current
    protected $allowedFields    = ['user','type','balance'];

    public function createAccount($data)
    {
        return $this->insert($data);
    }
}