<?php

namespace App\Models;

use CodeIgniter\Model;



class ItemPriceModel extends Model
{
    protected $table      = 'itemprice';
    protected $primaryKey = array('idItem', 'idShopChain');
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['price'];


    protected $validationRules    = [
        'idItem'     => 'required|in_db[`item`]',
        'idShopChain'     => 'required|in_db[`shopchain`]'
    ];


    protected $skipValidation     = false;




}