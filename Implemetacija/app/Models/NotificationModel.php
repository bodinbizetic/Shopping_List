<?php

namespace App\Models;

use CodeIgniter\Model;


define("JOIN_GROUP_REQ", ["msg" => "Join group", "type" => 0]);
define("NEW_GROUP_MEMBER", ["msg" => "New member group", "type" => 1]);
define("LIST_STATUS", ["msg" => "List status", "type" => 2]);


class NotificationModel extends Model
{

    protected $table      = 'notification';
    protected $primaryKey = 'idNotification';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['isRead', 'type', 'idUser', 'idGroup', 'text'];

    protected $validationRules    = [
        'text'     => 'max_length[256]',
        'idUser'        => 'required',
        'idGroup'     => 'required',
        'type'     => 'required'
    ];


    protected $skipValidation     = false;




}