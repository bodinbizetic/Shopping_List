<?php
/**
 * Autor - Olga Maslarevic 0007/2018
 */
namespace App\Models;

use CodeIgniter\Model;

define("ADMIN", 0);
define("USER", 1);

/**
 * Class InGroupModel - model za tabelu InGroup
 *
 * @package App\Models
 * @version 1.0
 */
class InGroupModel extends Model
{
    protected $table      = 'ingroup';
    protected $primaryKey = 'idInGroup';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['type', 'idUser', 'idGroup'];


    protected $validationRules    = [
        'idGroup'     => 'required',
        'idUser'     => 'required',
        'type'       => 'required'
    ];


    protected $skipValidation = false;

    /**
     * Vraca informacije o korisniku zadatog id-a
     *
     * @param int $userId - id korisnika
     * @return array
     */
    public function findByUserId(int $userId): array
    {
        return $this->where('idUser', $userId)->get()->getResultArray();
    }

    /**
     * Vraca informacije o korisnicima koji pripadaju zadatoj grupi
     *
     * @param int $groupId - id grupe
     * @return array
     */
    public function findByGroupId($groupId)
    {
        return $this->where('idGroup', $groupId)->get()->getResultArray();
    }


}