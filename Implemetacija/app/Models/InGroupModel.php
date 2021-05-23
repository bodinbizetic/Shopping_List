<?php

namespace App\Models;

use CodeIgniter\Model;

define("ADMIN", 0);
define("USER", 1);

class InGroupModel extends Model
{
    protected $table      = 'ingroup';
    protected $primaryKey = 'idInGroup';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['type', 'idUser', 'idGroup'];


    protected $validationRules    = [
        'idGroup'     => 'required',
        'idUser'     => 'required',
        'type'       => 'required'
    ];


    protected $skipValidation = false;

    public function findByUserId(int $userId): array
    {
        return $this->where('idUser', $userId)->get()->getResultArray();
    }


}