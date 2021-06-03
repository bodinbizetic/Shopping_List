<?php
/**
 * Autor - Olga Maslarevic 0007/2018
 */
namespace App\Models;

use CodeIgniter\Model;

/**
 * Konstante za tipove obavestenja
 */
define("JOIN_GROUP_REQ", ["msg" => "Join group", "type" => 0]);
define("NEW_GROUP_MEMBER", ["msg" => "New member group", "type" => 1]);
define("LIST_STATUS", ["msg" => "List status", "type" => 2]);
define("REMOVED_FROM_GROUP",["msg"=>"You have been removed from group","type"=>3]);

/**
 * Class NotificationModel  - model za tabelu Notification
 *
 * @package App\Models
 * @version 1.0
 */
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