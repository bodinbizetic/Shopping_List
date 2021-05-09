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


    protected $validationRules    = [
        'password'     => 'required|min_length[6]',
        'email'        => 'required|valid_email|is_unique[user.email]',
        'username'     => 'required|is_unique[user.username]',
        'fullName'     => 'required|min_length[2]'
    ];
    protected $validationMessages = [
        'email'        => [
            'is_unique' => 'Sorry. That email has already been taken. Please choose another.'
        ],
        'username'        => [
            'is_unique' => 'Sorry. That username has already been taken. Please choose another.'
        ]
    ];

    protected $skipValidation     = false;

    public function findByUsername($username) {
        return $this->where('username', $username)->first();
    }




}