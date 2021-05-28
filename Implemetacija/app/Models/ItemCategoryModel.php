<?php


namespace App\Models;


use CodeIgniter\Model;

class ItemCategoryModel extends Model
{
    protected $table      = 'itemcategory';
    protected $primaryKey = 'idItemCategory';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['idCategory', 'idItem'];

    protected $validationRules    = [
        'idCategory' => 'required|in_db[category,idCategory,Foreign key not in category]',
        'idItem' => 'required|in_db[item,idItem,Foreign key not in category]',
    ];


    protected $skipValidation     = false;

}