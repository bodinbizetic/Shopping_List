<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'user';
    protected $primaryKey = 'idUser';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['phone', 'fullName', 'password', 'type', 'image', 'username', 'email'];


    public function findByUsername($username) {
        return $this->where('username', $username)->first();
    }
    public function findByEmail($email) {
        return $this->where('email', $email)->first();
    }





}