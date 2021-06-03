<?php
/**
 * Autor - Olga Maslarevic 0007/2018
 */
namespace App\Models;

use CodeIgniter\Model;


/**
 * Class ShoppingListModel - model za tabelu ShoppingList
 *
 * @package App\Models
 * @version 1.0
 */
class ShoppingListModel extends Model
{
    protected $table      = 'shoppinglist';
    protected $primaryKey = 'idShoppingList';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['name', 'active', 'idShop', 'idGroup'];


    protected $validationRules    = [
        'idGroup'     => 'required',
        'name'     => 'required|max_length[45]',
        'active'     => 'required'
    ];


    protected $skipValidation     = false;





}