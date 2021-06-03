<?php
/**
 * Autor - Olga Maslarevic 0007/2018
 */
namespace App\Models;

use CodeIgniter\Model;


/**
 * Class ShopChainModel - model za tabelu ShopChain
 *
 * @package App\Models
 * @version 1.0
 */
class ShopChainModel extends Model
{
    protected $table      = 'shopchain';
    protected $primaryKey = 'idShopChain';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['name', 'idShopChain'];


    protected $validationRules    = [
        'name'     => 'required|max_length[45]'
    ];


    protected $skipValidation     = false;




}