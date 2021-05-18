<?php

namespace App\Models;

use CodeIgniter\Model;



class ListContainsModel extends Model
{
    protected $table      = 'listcontains';
    protected $primaryKey = array('idShoppingList', 'idItem');
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['bought'];


    protected $validationRules    = [
        'idShoppingList'     => 'required|in_db[`shoppinglist`]',
        'idItem'     => 'required|in_db[`item`]',
        'idUser'     => 'required|in_db[`user`]',
        'bought'     => 'required'
    ];


    protected $skipValidation     = false;




}