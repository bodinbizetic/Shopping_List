<?php

namespace App\Models;

use CodeIgniter\Model;



class ShopChainModel extends Model
{
    protected $table      = 'shopchain';
    protected $primaryKey = 'idShopChain';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['name'];


    protected $validationRules    = [
        'idShopChain'     => 'required',
        'name'     => 'required|max_length[45]'
    ];


    protected $skipValidation     = false;




}