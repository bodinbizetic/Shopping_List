<?php

namespace App\Controllers;

use App\Models\InGroupModel;
use App\Models\NotificationModel;
use App\Models\GroupModel;



class Notification extends BaseController
{

    private $types_text = ['Join Group', 'New members', 'Removed from Group', 'List status'];
    private $types_class = ['label label-success', 'label label-primary', 'label label-danger', 'label label-info'];



    public function index()
    {
        // auth guard
        if(!$this->session->has('user'))
            return redirect()->to('/login/index');
        $user = $this->session->get('user');

        $notificationModel = new NotificationModel();

        $notifications = $notificationModel->where('idUser', $user['idUser'])
            ->select('*')
            ->orderBy('isRead', 'ASC')
            ->join('group', 'group.idGroup = notification.idGroup')
            ->paginate(3, 'notif-group');
        $pager = $notificationModel->pager;

        echo view('common/header');
        echo view('notification', ['notifications' => $notifications, 'pager' => $pager, 'typesText' => $this->types_text, 'typesClass' => $this->types_class]);
        echo view('common/footer');
    }

    public function setDoneFlag($idNotification) {
        $notificationModel = new NotificationModel();
        $notificationModel->update($idNotification, ['isRead' => 1]);
    }

    public function approve($idNotification)
    {
        $notificationModel = new NotificationModel();
        $notification = $notificationModel->where('idNotification', $idNotification)->first();
        $group = (new GroupModel())->where('idGroup', $notification['idGroup'])->first();

        $new_notification = [
            'idGroup' => $notification['idGroup'],
            'type'    => NEW_GROUP_MEMBER['type'],
            'isRead'  => 0,
            'text'    => NEW_GROUP_MEMBER['msg']. " ". $group['name'],
        ];

        $group_members = (new InGroupModel())->where('idGroup', $group['idGroup'])->findAll();

        foreach ($group_members as $group_member) {
            if($group_member['idUser'] == $this->session->get('user')['idUser'])
                continue;
            $new_notification['idUser'] = $group_member['idUser'];
            $notificationModel->save($new_notification);
        }

        $notificationModel->update($idNotification, ['isRead' => 1]);

        return redirect()->to('/notification/index');
    }

    public function decline($idNotification)
    {
        $this->setDoneFlag($idNotification);
        return redirect()->to('/notification/index');
    }

    public function markDone($idNotification)
    {
        $this->setDoneFlag($idNotification);
        return redirect()->to('/notification/index');
    }
}
