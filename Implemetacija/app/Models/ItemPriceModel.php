<?php
/**
 * Autor - Olga Maslarevic 0007/2018
 */
namespace App\Models;

use CodeIgniter\Model;


/**
 * Class ItemPriceModel - model za tabelu ItemPrice
 *
 * @package App\Models
 * @version 1.0
 */
class ItemPriceModel extends Model
{
    protected $table      = 'itemprice';
    protected $primaryKey = 'idItemPrice';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['price', 'idItem', 'idShopChain', 'idItemPrice'];


    protected $validationRules    = [
        'idItem'     => 'required',
        'idShopChain'     => 'required',
        'price' => 'required',
    ];


    protected $skipValidation     = false;




}