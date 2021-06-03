<?php
/**
 * Autor - Olga Maslarevic 0007/2018
 */
namespace App\Models;

use CodeIgniter\Model;


/**
 * Class ItemModel - model za tabelu Item
 *
 * @package App\Models
 * @version 1.0
 */
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