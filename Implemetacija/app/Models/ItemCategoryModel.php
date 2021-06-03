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
        'idCategory' => 'required',
        'idItem' => 'required',
    ];


    protected $skipValidation     = false;

}