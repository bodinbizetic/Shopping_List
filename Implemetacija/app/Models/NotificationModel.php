<?php

namespace App\Models;

use CodeIgniter\Model;


class NotificationModel extends Model
{
    protected $table      = 'notification';
    protected $primaryKey = 'idNotification';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['isRead'];

    protected $validationRules    = [
        'text'     => 'required|min_length[1]|max_length[256]',
        'idUser'        => 'required|in_db[`user`]',
        'idGroup'     => 'required|in_db[`group`]',
        'type'     => 'required'
    ];


    protected $skipValidation     = false;




}