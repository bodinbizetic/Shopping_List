<?php

/**
 * Autor - Olga Masalrevic 0007/2018
 */
namespace App\Models;

use CodeIgniter\Model;

/**
 * Class UserModel - model za tabelu User
 *
 * @package App\Models
 * @version 1.0
 */
class UserModel extends Model
{
    protected $table      = 'user';
    protected $primaryKey = 'idUser';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['phone', 'fullName', 'password', 'type', 'image', 'username', 'email'];

    /**
     * Dohvata informacije o korisniku sa datim korisnickim imenom
     *
     * @param $username - korisnicko ime
     * @return array|object|null
     */
    public function findByUsername($username) {
        return $this->where('username', $username)->first();
    }

    /**
     * Dohvata informacije o korisniku sa datim emailom
     *
     * @param $email - email korisnika
     * @return array|object|null
     */
    public function findByEmail($email) {
        return $this->where('email', $email)->first();
    }





}