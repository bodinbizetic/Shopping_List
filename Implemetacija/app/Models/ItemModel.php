<?php

namespace App\Models;

use CodeIgniter\Model;



class ItemModel extends Model
{
    protected $table      = 'item';
    protected $primaryKey = 'idItem';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['name', 'quantity', 'metrics', 'image', 'isCenoteka'];


    protected $validationRules    = [
        'name'     => 'required|max_length[255]',
        'quantity'     => 'required|max_length[45]',
        'metrics' => 'required',
        'image' => 'max_length[255]'
    ];


    protected $skipValidation     = false;




}