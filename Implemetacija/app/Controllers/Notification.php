<?php
/**
 * Autor - Olga Maslarevic 0007/2018
 */
namespace App\Controllers;

use App\Models\InGroupModel;
use App\Models\NotificationModel;
use App\Models\GroupModel;


/**
 * Class Notification - prikaz obavestenja
 *
 * @package App\Controllers
 * @version 1.0
 */
class Notification extends BaseController
{
    /**
     * @var string[] - mapiranje tipa notifikacije sa prikazom u View
     */
    private $types_text = ['Join Group', 'New members', 'List status','Removed from group'];
    private $types_class = ['label label-success', 'label label-primary','label label-info', 'label label-info'];

    /**
     * Prikaz svih obavestenja za ulogovanog korisnika
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
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

        echo view('common/header', [ 'notifications' => '']);
        echo view('notification', ['notifications' => $notifications, 'pager' => $pager, 'typesText' => $this->types_text, 'typesClass' => $this->types_class]);
        echo view('common/footer');
    }

    /**
     * Postavlja status da je notifikacija procitana
     *
     * @param $idNotification - id nostifikacije
     * @throws \ReflectionException
     */
    public function setDoneFlag($idNotification) {
        $notificationModel = new NotificationModel();
        $notificationModel->update($idNotification, ['isRead' => 1]);
    }

    /**
     * Pridruzuje korisnika novoj grupi i salje obavestenja starim clanovima te grupe o novom clanu
     *
     * @param $idNotification - id notifikacije za pristup grupi
     * @return \CodeIgniter\HTTP\RedirectResponse
     * @throws \ReflectionException
     */
    public function approve($idNotification)
    {
        $notificationModel = new NotificationModel();
        $groupModel = new GroupModel();
        $inGroupModel = new InGroupModel();

        $notification = $notificationModel->where('idNotification', $idNotification)->first();
        $group = $groupModel->where('idGroup', $notification['idGroup'])->first();

        $new_notification = [
            'idGroup' => $notification['idGroup'],
            'type'    => NEW_GROUP_MEMBER['type'],
            'isRead'  => 0,
            'text'    => NEW_GROUP_MEMBER['msg']. " ". $group['name'],
        ];

        $group_members = $inGroupModel->where('idGroup', $group['idGroup'])->findAll();

        foreach ($group_members as $group_member) {
            if($group_member['idUser'] == $this->session->get('user')['idUser'])
                continue;
            $new_notification['idUser'] = $group_member['idUser'];
            $notificationModel->insert($new_notification);
        }

        $new_inGroup = [
            'type' => '0',
            'idGroup' => $group['idGroup'],
            'idUser' => $this->session->get('user')['idUser']
        ];

        $inGroupModel->save($new_inGroup);
        $notificationModel->update($idNotification, ['isRead' => 1]);

        return redirect()->to('/notification/index');
    }

    /**
     * Oznacava notifikaciju kao procitanu i odbija pristup novoj grupi
     *
     * @param $idNotification - id notifikacije za pristup grupi
     * @return \CodeIgniter\HTTP\RedirectResponse
     * @throws \ReflectionException
     */
    public function decline($idNotification)
    {
        $this->setDoneFlag($idNotification);
        return redirect()->to('/notification/index');
    }

    /**
     * Notifikacija je procitana - arhivira se
     *
     * @param $idNotification - id notifikacije koja je procitana
     * @return \CodeIgniter\HTTP\RedirectResponse
     * @throws \ReflectionException
     */
    public function markDone($idNotification)
    {
        $this->setDoneFlag($idNotification);
        return redirect()->to('/notification/index');
    }
}
