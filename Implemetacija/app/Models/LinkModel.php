<?php
/**
 * Author - Bodin Bizetic 0058/2018
 */

namespace App\Models;


use CodeIgniter\Model;

/**
 * Class LinkModel - model for Link table
 * @package App\Models
 */
class LinkModel extends Model
{
    protected $table      = 'link';
    protected $primaryKey = 'idLink';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['idShoppingList', 'link', 'writable'];

    protected $validationRules    = [
        'idShoppingList' => 'required|in_db[shoppinglist,idShoppingList,No list found]',
        'link' => 'required|max_length[255]',
        'writable' => 'required'
    ];


    protected $skipValidation     = false;
}