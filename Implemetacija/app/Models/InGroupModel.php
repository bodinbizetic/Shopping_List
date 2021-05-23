<?php

namespace App\Models;

use CodeIgniter\Model;



class InGroupModel extends Model
{
    protected $table      = 'ingroup';
    protected $primaryKey = array('idGroup', 'idUser');
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['type', 'idUser', 'idGroup'];


    protected $validationRules    = [
        'idGroup'     => 'required|in_db[group,idGroup]',
        'idUser'     => 'required|in_db[user,idUser]',
        'type'       => 'required'
    ];


    protected $skipValidation     = false;

    public function findByUserId(int $userId): array
    {
        return $this->where('idUser', $userId)->get()->getResultArray();
    }


}