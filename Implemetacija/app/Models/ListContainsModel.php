<?php

namespace App\Models;

use CodeIgniter\Model;



class ListContainsModel extends Model
{
    protected $table      = 'listcontains';
    protected $primaryKey = 'idListContains';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['bought', 'idShoppingList', 'idItem', 'bought', 'idUser'];


    protected $validationRules    = [
        'idShoppingList'     => 'required|in_db[shoppinglist,idShoppingList]',
        'idItem'     => 'required|in_db[item,idItem]',
        'idUser'     => 'required|in_db[user,idUser,NotExist]',
    ];


    protected $skipValidation     = false;

    public function findAllInList($idShoppingList): array
    {
        return $this->where('idShoppingList', $idShoppingList)->get()->getResultArray();
    }
}