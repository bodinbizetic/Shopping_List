<?php

namespace App\Models;

use CodeIgniter\Model;



class ItemPriceModel extends Model
{
    protected $table      = 'itemprice';
    protected $primaryKey = 'idItemPrice';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['price', 'idItem', 'idShopChain', 'idItemPrice'];


    protected $validationRules    = [
        'idItem'     => 'required|in_db[item,idItem,Not valid item]',
        'idShopChain'     => 'required|in_db[shopchain,idShopChain, Not valid shop]',
        'price' => 'required',
    ];


    protected $skipValidation     = false;




}