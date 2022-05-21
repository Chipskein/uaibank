<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersSessionsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'UsersSessions';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user','logged_at','logoff_at'];

    public function insertSession($data=null)
    {   
        $this->insert($data);
    }
}
