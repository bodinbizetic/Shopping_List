<?php

namespace App\Models;

use CodeIgniter\Model;



class ShoppingListModel extends Model
{
    protected $table      = 'shoppinglist';
    protected $primaryKey = 'idShoppingList';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['name', 'active', 'idShop', 'idGroup'];


    protected $validationRules    = [
        'idGroup'     => 'required|in_db[group,idGroup,Not in group]',
        'name'     => 'required|max_length[45]',
        'active'     => 'required'
    ];


    protected $skipValidation     = false;





}