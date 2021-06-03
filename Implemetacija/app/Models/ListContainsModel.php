<?php
/**
 * Autor - Olga Maslarevic 0007/2018
 */
namespace App\Models;

use CodeIgniter\Model;


/**
 * Class ListContainsModel - model za tabelu ListContains
 *
 * @package App\Models
 * @version 1.0
 */
class ListContainsModel extends Model
{
    protected $table      = 'listcontains';
    protected $primaryKey = 'idListContains';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['bought', 'idShoppingList', 'idItem', 'idUser'];


    protected $validationRules    = [
        'idShoppingList'     => 'required',
        'idItem'     => 'required',
        'idUser'     => 'required',
    ];


    protected $skipValidation     = false;

    public function findAllInList($idShoppingList): array
    {
        return $this->where('idShoppingList', $idShoppingList)->get()->getResultArray();
    }
}