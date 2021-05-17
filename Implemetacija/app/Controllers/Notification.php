<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use App\Models\GroupModel;



class Notification extends BaseController
{

    private $types_text = ['Join Group', 'New members', 'Removed from Group', 'List status'];
    private $types_class = ['label label-success', 'label label-primary', 'label label-danger', 'label label-info'];



    public function index()
    {

        $notificationModel = new NotificationModel();

        $notifications = $notificationModel->select('*')->orderBy('isRead', 'ASC')
            ->join('group', 'group.idGroup = notification.idGroup')->paginate(1, 'notif-group');
        $pager = $notificationModel->pager;

        echo view('common/header');
        echo view('notification', ['notifications' => $notifications, 'pager' => $pager, 'typesText' => $this->types_text, 'typesClass' => $this->types_class]);
        echo view('common/footer');
    }

    private function setDoneFlag($idNotification)
    {
        $notificationModel = new NotificationModel();
        $notificationModel->update($idNotification, ['isRead' => 1]);

        $this->index();
    }

    public function approve($idNotification)
    {
        $this->setDoneFlag($idNotification);
        // To Do when finish groups
    }

    public function decline($idNotification)
    {
        $this->setDoneFlag($idNotification);
        // To Do when finish groups
    }

    public function markDone($idNotification)
    {
        $this->setDoneFlag($idNotification);
    }
}
