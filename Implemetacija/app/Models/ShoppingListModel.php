<?php

namespace App\Models;

use CodeIgniter\Model;



class ShoppingListModel extends Model
{
    protected $table      = 'shoppinglist';
    protected $primaryKey = 'idShoppingList';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['name', 'active', 'idShop'];


    protected $validationRules    = [
        'idShoppingList'     => 'required',
        'idGroup'     => 'required|in_db[`group`]',
        'name'     => 'required|max_length[45]',
        'active'     => 'required'
    ];


    protected $skipValidation     = false;





}