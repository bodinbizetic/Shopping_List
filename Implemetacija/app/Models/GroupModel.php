<?php
/**
 * Autor - Olga Maslarevic 0007/2018
 */
namespace App\Models;

use CodeIgniter\Model;

/**
 * Class GroupModel - model za tabelu Group
 *
 * @package App\Models
 * @version 1.0
 */
class GroupModel extends Model
{
    protected $table      = 'group';
    protected $primaryKey = 'idGroup';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['name', 'description', 'image'];
    
    protected $validationRules    = [
        'name'     => 'required|max_length[60]'
    ];


    protected $skipValidation     = false;

}