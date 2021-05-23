<?php

namespace App\Models;

use CodeIgniter\Model;



class InGroupModel extends Model
{
    protected $table      = 'ingroup';
    protected $primaryKey = array('idGroup', 'idUser');
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['type'];


    protected $validationRules    = [
        'idGroup'     => 'required|in_db[`group`]',
        'idUser'     => 'required|in_db[`user`]',
        'type'       => 'required'
    ];


    protected $skipValidation     = false;

    public function findGroupMembers($group) {
        return $this->where('idGroup', $group);
    }

    public function findUsersGroups($user) {
        return $this->where('idUser', $user);
    }

}