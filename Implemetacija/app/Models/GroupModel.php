<?php

namespace App\Models;

use CodeIgniter\Model;


class GroupModel extends Model
{
    protected $table      = 'group';
    protected $primaryKey = 'idGroup';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['name', 'description', 'image'];
    
    protected $validationRules    = [
        'name'     => 'required|max_length[60]'
    ];


    protected $skipValidation     = false;

}