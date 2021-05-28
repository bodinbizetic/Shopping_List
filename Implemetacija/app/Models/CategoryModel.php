<?php


namespace App\Models;


use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table      = 'category';
    protected $primaryKey = 'idCategory';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['name', 'idCategory', 'image'];

    protected $validationRules    = [
        'name'     => 'required|max_length[255]',
        'image' => 'max_length[255]',
    ];


    protected $skipValidation     = false;

}