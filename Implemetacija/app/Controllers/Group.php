<?php

namespace App\Controllers;

use App\Models\GroupModel;
use App\Models\InGroupModel;
use App\Models\ItemModel;
use App\Models\ListContainsModel;
use App\Models\NotificationModel;
use App\Models\ShoppingListModel;
use App\Models\UserModel;
use CodeIgniter\Model;

/**
 * Autor: Tamara Avramovic 2018/0293
 * Class Group - klasa za upravljanje grupama
 * Ukljucuje: Prikazivanje svih korisnikovih grupa, kreiranje nove grupe,
 *            editovanje grupa, pregled informacija o pojedinacnoj grupi
 * @package App\Controllers
 * @version 5.0
 */

class Group extends BaseController
{
    /**
     * Prikazivanje svih korisnikovih grupa
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function index($info=null)
    {
        // auth guard
        if(!$this->session->has('user'))
            return redirect()->to('/login/index');
        $user = $this->session->get('user');

        $inGroupModel = new InGroupModel();
        $groupModel = new GroupModel();

        $ingroups = $inGroupModel->findByUserId($this->session->get('user')['idUser']);
        $userGroups = [];

        $i=0;
        foreach ($ingroups as $ingroup) {
            $idGroup = $ingroup['idGroup'];
            $group = $groupModel->find($idGroup);
            $userGroups[$i++] = $group;
        }

        echo view('common/header', ['groups' => '']);
        echo view('Views/groups/groups',['groups'=>$userGroups, 'ingroups'=>$ingroups, 'info'=>$info]);
        echo view('common/footer');
    }

    /**
     * Prikazuje stranicu za kreiranje nove grupe
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function renderNewGroup()
    {
        // auth guard
        if(!$this->session->has('user'))
            return redirect()->to('/login/index');
        $user = $this->session->get('user');

        echo view('common/header', ['groups' => '']);
        echo view('groups/newGroup');
        echo view('common/footer');
    }

    /**
     * Menja informacije o grupi u bazi
     * @param $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     * @throws \ReflectionException
     */
    public function editGroup($id)
    {
        // auth guard
        if(!$this->session->has('user'))
            return redirect()->to('/login/index');

        $user = $this->session->get('user');
        $inGroupModel = new InGroupModel();
        $inGroup = $inGroupModel->where('idUser',$user['idUser'])->where('idGroup',$id)->first();

        if($inGroup==null || $inGroup['type']=='0'){
            Error::show("Edit not allowed");
        }


        $name = $this->request->getPost('group_name');
        $description = $this->request->getPost('description');

        $groupModel = new GroupModel();

        $adminsToBe=[];
        $i=0;

        if(!empty($_POST['admin'])){
            foreach($_POST['admin'] as $selected){
                $adminsToBe[$i]=$selected;
                $i++;
            }
        }

        foreach ($adminsToBe as $admin){
            $this->changeAdmin($id, $admin);
        }

        $data = [
            'name'=>$name,
            'description'=>$description
        ];

        if($this->request->getFile('image')->getName() != "") {
            $time_unique = strtotime("now");
            $this->request->getFile('image')->move(ROOTPATH . 'public\groupUploads\\' . $time_unique, $this->request->getFile('image')->getName());
            $data['image'] = $time_unique. "/". $this->request->getFile('image')->getName();
        } else
           $data['image'] = $groupModel->find($id)['image'];

        $groupModel->update($id,$data);

        return redirect()->to('/group/index/'.'Edit successful');
    }

    /**
     * Prikazuje stranicu za menjanje informacija o grupi
     * @param $id
     * @param null $errors
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function renderEditGroup($id, $errors=null)
    {
        // auth guard
        if(!$this->session->has('user'))
            return redirect()->to('/login/index');

        $user = $this->session->get('user');
        $inGroupModel = new InGroupModel();
        $inGroup = $inGroupModel->where('idUser',$user['idUser'])->where('idGroup',$id)->first();

        if($inGroup==null || $inGroup['type']=='0'){
            Error::show("Edit not allowed");
        }

        $userModel = new UserModel();
        $inGroupModel = new InGroupModel();
        $inGroupUsers = $inGroupModel->where('idGroup',$id)->findAll();

        $i=0;

        $members=[];

        foreach ($inGroupUsers as $inGroupUser){
            $user = $userModel->find($inGroupUser['idUser']);
            $members[$i++]=$user;
        }

        $groupModel = new GroupModel();
        $group = $groupModel->find($id);

        $data = [
            'members'=>$members,
            'name'=>$group['name'],
            'description'=>$group['description'],
            'image'=>$group['image'],
            'ingroup'=>$inGroupUsers,
            'groupId'=>$group['idGroup'],
            'myId'=>$this->session->get('user')['idUser'],
            'inGroup'=>$inGroupUsers,
            'errors' => $errors
        ];

        echo view('common/header', ['groups' => '']);
        echo view('groups/editGroup1',$data);
        echo view('common/footer');
    }

    /**
     * Menja tip izabranog korisnika u grupi - postavlja korisnika za admina grupe
     * @param $groupId
     * @param $memberId
     * @return \CodeIgniter\HTTP\RedirectResponse
     * @throws \ReflectionException
     */
    public function changeAdmin($groupId, $memberId)
    {
        // auth guard
        if(!$this->session->has('user'))
            return redirect()->to('/login/index');
        $user = $this->session->get('user');

        $inGroupModel = new InGroupModel();
        $ingroup = $inGroupModel->where('idGroup',$groupId)->where('idUser',$memberId)->findAll();

        if(count($ingroup)) {

            $id = $ingroup[0]['idInGroup'];

            $data = [
                'idUser' => $memberId,
                'idGroup' => $groupId,
                'type' => '1'
            ];

            $inGroupModel->update($id, $data);

        }
    }

    /**
     * Prikazuje stranicu za pregled informacija i statistike grupe
     * @param $idGroup
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function viewGroup($idGroup)
    {
        // auth guard
        if(!$this->session->has('user'))
            return redirect()->to('/login/index');

        $user = $this->session->get('user');
        $inGroupModel = new InGroupModel();
        $inGroup = $inGroupModel->where('idUser',$user['idUser'])->where('idGroup',$idGroup)->first();

        if($inGroup==null){
            Error::show("View not allowed");
        }

        $groupModel = new GroupModel();
        $group = $groupModel->find($idGroup);

        $userModel = new UserModel();
        $inGroupModel = new InGroupModel();
        $inGroupUsers = $inGroupModel->where('idGroup',$idGroup)->findAll();

        $i=0;

        $members=[];

        foreach ($inGroupUsers as $inGroupUser){
            $user = $userModel->find($inGroupUser['idUser']);
            $members[$i]=$user;
            $i++;
        }

        $monthSpending = $this->getSpendingByMonth($idGroup);
        $noListsByMonth = $this->getNoListsByMonth($idGroup);

        $popularItemsYear = $this->getPopularItemsYear(5, $idGroup);
        $popularItemsMonth= $this->getPopularItemsMonth(5, $idGroup);

        $data=[
            'chart_data_spending' => $this->displayAsChartSpending($monthSpending),
            'chart_data_lists' => $this->displayAsChartNoLists($noListsByMonth),
            'data_for_pie_year' =>  $this->displayAsPie($popularItemsYear),
            'data_for_pie_month' => $this->displayAsPie($popularItemsMonth),
            'group' => $group,
            'members' => $members,
            'inGroup' => $inGroupUsers
        ];

        echo view('common/header', ['groups' => '']);
        echo view('groups/singleGroup1',$data);
        echo view('common/footer');
    }

    /**
     * Racuna prosecnu mesecnu potrosnju za grupu
     * @param $idGroup
     * @return array
     */
    private function getSpendingByMonth($idGroup)
    {
        $listContainsModel = new ListContainsModel();
        $shoppingList = new ShoppingListModel();
        return $shoppingList->where('idGroup',$idGroup)
            ->join('listcontains','shoppinglist.idShoppingList = listcontains.idShoppingList')
            ->where('YEAR(bought)', date('Y'))
            ->whereNotIn('idShop', ['NULL'])
            ->join('itemprice', 'itemprice.idItem = listcontains.idItem AND itemprice.idShopChain = shoppinglist.idShop')
            ->join('item', 'item.idItem = listcontains.idItem')
            ->select('MONTH(bought) AS month, SUM(itemprice.price * item.quantity) AS spending')
            ->groupBy('month')
            ->findAll();

    }

    /**
     * Vraca ukupan broj spiskova po mesecima za grupu
     * @param $idGroup
     * @return array
     */
    private function getNoListsByMonth($idGroup)
    {
        $shoppingListModel = new ShoppingListModel();
        $toReturn =  $shoppingListModel->where('idGroup', $idGroup)
            ->select('MONTH(createdAt) as month, COUNT(*) as count')
            ->groupBy('month')
            ->findAll();
        return array_filter($toReturn, function($elem) {
            return $elem['month'] != null;
        });
    }

    /**
     * Vraca najcesce trazene namirnice po godini za grupu
     * @param $limit
     * @param $idGroup
     * @return array
     */
    private function getPopularItemsYear($limit, $idGroup)
    {
        $shoppingList = new ShoppingListModel();
        return $shoppingList->where('idGroup',$idGroup)
            ->join('listcontains','shoppinglist.idShoppingList = listcontains.idShoppingList')
            ->where('YEAR(bought)', date('Y'))
            ->join('item', 'item.idItem = listcontains.idItem')
            ->select('listcontains.idItem AS idItem, item.name AS name, COUNT(listcontains.idItem) AS count')
            ->groupBy('listcontains.idItem')
            ->orderBy('count', "DESC")
            ->findAll($limit);
    }

    /**
     * Vraca najcesce trazene namirnice po mesecu za grupu
     * @param $limit
     * @param $idGroup
     * @return array
     */
    private function getPopularItemsMonth($limit, $idGroup)
    {
        $listContainsModel = new ListContainsModel();
        $shoppingList = new ShoppingListModel();
        return $shoppingList->where('idGroup',$idGroup)
            ->join('listcontains','shoppinglist.idShoppingList = listcontains.idShoppingList')
            ->where('MONTH(bought)', date('m'))
            ->join('item', 'item.idItem = listcontains.idItem')
            ->select('listcontains.idItem AS idItem, item.name AS name, COUNT(listcontains.idItem) AS count')
            ->groupBy('listcontains.idItem')
            ->orderBy('count', "DESC")
            ->findAll($limit);
    }

    /**
     * Prikazuje niz kao grafikon
     * @param $monthSpendings
     * @return false|string
     */
    private function displayAsChartSpending($monthSpendings)
    {
        $data = [];
        $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        foreach ($monthSpendings as $monthSpending) {
            $data['label'][] = $months[$monthSpending['month'] - 1];
            $data['data'][] = $monthSpending['spending'];

        }
        return json_encode($data);
    }

    /**
     * Prikazuje niz kao grafikon
     * @param $monthNoLists
     * @return false|string
     */
    private function displayAsChartNoLists($monthNoLists)
    {
        $noLists = [];
        $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        foreach ($monthNoLists as $monthNoList) {
            $noLists['label'][] = $months[$monthNoList['month'] - 1];
            $noLists['data'][] = $monthNoList['count'];

        }
        return json_encode($noLists);
    }

    /**
     * Prikazuje niz kao pitu
     * @param $popularItems
     * @return false|string
     */
    private function displayAsPie($popularItems)
    {
        $arrOfArr = [];
        foreach ($popularItems as $popularItem) {
            array_push($arrOfArr, [$popularItem['name'], (int)$popularItem['count']]);
        }
        return json_encode($arrOfArr);
    }

    /**
     * Za zadato korisnicko ime proverava da li korisnik postoji;
     * Ukoliko postoji, poziva metod sendCall i salje poruku o uspehu;
     * Ukoliko ne postoji salje poruku o gresci;
     * @param $idGroup
     * @param null $username
     */
    public function addNewMember($idGroup, $username=null) {

        $active_user = $this->session->get('user');
        $inGroupModel = new InGroupModel();
        $inGroup = $inGroupModel->where('idUser',$active_user['idUser'])->where('idGroup',$idGroup)->first();

        if($inGroup==null || $inGroup['type']=='0'){
            Error::show("Edit not allowed");
        }

        if($username!=null) {

            $userModel = new UserModel();
            $user = $userModel->findByUsername($username);
            $groupModel = new GroupModel();
            $group = $groupModel->find($idGroup);

            if ($user == null) {
                $this->renderEditGroup($idGroup, ['There is no user with set username', 0]);
            } else {
                $this->sendCall($user, $group);
                $this->renderEditGroup($idGroup, ['Invite sent', 1]);
            }
        } else
            $this->renderEditGroup($idGroup, ['Please enter username', 0]);
    }

    /**
     * Kreira grupu sa podacima unetim u formu
     * @return \CodeIgniter\HTTP\RedirectResponse
     * @throws \ReflectionException
     */
    public function newGroup() {
        // auth guard
        if(!$this->session->has('user'))
            return redirect()->to('/login/index');
        $user = $this->session->get('user');

        $name = $this->request->getPost('group_name');
        $desc = $this->request->getPost('description');

        $data = [
            'name'=>$name,
            'description'=>$desc,
        ];

        if($this->request->getFile('image')->getName() != "") {
            $time_unique = strtotime("now");
            $this->request->getFile('image')->move(ROOTPATH . 'public\groupUploads\\' . $time_unique, $this->request->getFile('image')->getName());
            $data['image'] = $time_unique. "/". $this->request->getFile('image')->getName();
        } else
            $data['image'] = null;

        $groupModel = new GroupModel();
        $groupId = $groupModel->insert($data);

        $info = 'New group created. <br>';

        $group = $groupModel->find($groupId);

        $userModel = new UserModel();

        $membersToCall=[];
        $i=0;

        if(!empty($_POST['members'])) {
            foreach ($_POST['members'] as $member) {
                $user = $userModel->findByUsername($member);

                if ($user != null) {
                    $membersToCall[$i++] = $user;
                }
                else{
                    $info = $info . 'Wrong username: '.$member . '<br>';
                }

            }

            $info = $info . 'You can invite members in Edit';

            foreach ($membersToCall as $mem) {
                $this->sendCall($mem, $group);
            }

        }

        $userId = $this->session->get('user')['idUser'];
        $this->joinGroup($userId,$groupId,1);

        return redirect()->to(base_url('/group/index/'.$info));
    }

    /**
     * Postavlja korisnika za clana zadate grupe i postavlja ga admina
     * @param $userId
     * @param $groupId
     * @param $type
     * @return \CodeIgniter\HTTP\RedirectResponse
     * @throws \ReflectionException
     */
    public function joinGroup($userId, $groupId,$type){
        // auth guard
        if(!$this->session->has('user'))
            return redirect()->to('/login/index');

        $ingroupData = [
            'idUser'=>$userId,
            'idGroup'=>$groupId,
            'type'=>$type
        ];

        $ingroupModel = new InGroupModel();
        $ingroupModel->save($ingroupData);
    }

    /**
     * Salje notifikaciju korisniku da je pozvan u grupu
     * @param $member
     * @param $group
     * @return \CodeIgniter\HTTP\RedirectResponse
     * @throws \ReflectionException
     */
    public function sendCall($member,$group){

        // auth guard
        if(!$this->session->has('user'))
            return redirect()->to('/login/index');

        $notificationModel = new NotificationModel();
        $data = [
                'idGroup' => $group['idGroup'],
                'idUser'=>$member['idUser'],
                'type'    => JOIN_GROUP_REQ['type'],
                'isRead'  => 0,
                'text'    => JOIN_GROUP_REQ['msg']. " ". $group['name'],
        ];
        $notificationModel->save($data);
    }

    /**
     * Uklanja zadatog korisnika iz grupe
     * Ukoliko je zadati korisnik ujedno i ulogovani korisnik, poziva metod leaveGroup;
     * @param $groupId
     * @param $userId
     * @return \CodeIgniter\HTTP\RedirectResponse
     * @throws \ReflectionException
     */
    public function removeFromGroup($groupId, $userId){

        // auth guard
        if(!$this->session->has('user'))
            return redirect()->to('/login/index');

        $active_user = $this->session->get('user');
        $inGroupModel = new InGroupModel();
        $inGroup = $inGroupModel->where('idUser',$active_user['idUser'])->where('idGroup',$groupId)->first();

        if($inGroup==null || $inGroup['type']=='0'){
            Error::show("Edit not allowed");
        }

        $groupModel = new GroupModel();
        $group = $groupModel->find($groupId);
        $myId = $active_user['idUser'];
        if($myId==$userId) {
            $this->leaveGroup($groupId);
            return redirect()->to('/group/index/'.'You are no longer a member');
        }
        else{
            $inGroup = $inGroupModel->where('idUser',$userId)->where('idGroup',$group['idGroup'])->findAll();

            $id = $inGroup[0]['idInGroup'];

            $inGroupModel->delete($id);

            $notificationModel = new NotificationModel();
            $data = [
                'idGroup' => $group['idGroup'],
                'idUser'=>$userId,
                'type'    => REMOVED_FROM_GROUP['type'],
                'isRead'  => 0,
                'text'    => REMOVED_FROM_GROUP['msg']. " ". $group['name'],
            ];

            $notificationModel->save($data);

           return redirect()->to(base_url('/group/renderEditGroup/'.$groupId));
        }
    }

    /**
     * Uklanja ulogovanog korisnika iz zadate grupe
     * Ukoliko je bio poslednji clan grupe poziva se metod deleteGroup
     * @param $groupId
     * @return \CodeIgniter\HTTP\RedirectResponse
     * @throws \ReflectionException
     */
    public function leaveGroup($groupId){

        // auth guard
        if(!$this->session->has('user'))
            return redirect()->to('/login/index');

        $active_user = $this->session->get('user');
        $inGroupModel = new InGroupModel();
        $inGroup = $inGroupModel->where('idUser',$active_user['idUser'])->where('idGroup',$groupId)->first();

        if($inGroup==null){
            Error::show("Edit not allowed");
        }

        $thisGroup = $inGroupModel->findByGroupId($groupId);

        $userId = $active_user['idUser'];

        $inGroup = $inGroupModel->where('idUser',$userId)->where('idGroup',$groupId)->findAll(1)[0];

        $admins = $inGroupModel->where('idGroup',$groupId)->where('type','1')->findAll();

        if(($inGroup['type']=='1') && (count($admins)==1)){
            foreach ($thisGroup as $memInGroup){
                if($memInGroup['idUser']!=$userId){
                    $id = $inGroupModel->where('idUser',$memInGroup['idUser'])->where('idGroup',$groupId)->findAll(1)[0];
                    $data = [
                        'idGroup'=>$groupId,
                        'idUser' => $memInGroup['idUser'],
                        'type'=>'1'
                    ];
                    $inGroupModel->update($id['idInGroup'],$data);
                    break;
                }
            }
        }

        $inGroupModel->delete($inGroup['idInGroup']);


        if(count($thisGroup)==1) {
            $this->deleteGroup($groupId);
        }

        return redirect()->to('/group/index/'.'You are no longer member');
    }

    /**
     * Brisu se svi spiskovi vezani za zadatu grupu,
     * brisu se sve notifikacije vezane za ovu grupu
     * Brise se sama grupa
     * @param $idGroup
     */
    private function deleteGroup($idGroup){

        $groupModel = new GroupModel();
        $listContainsModel = new ListContainsModel();
        $itemModel = new ItemModel();

        $inGroupModel = new InGroupModel();
        $thisGroup = $inGroupModel->findByGroupId($idGroup);

        $shoppingListModel = new ShoppingListModel();
        $allList = $shoppingListModel->where('idGroup',$idGroup)->findAll();
        foreach ($allList as $list){
            $listContains = $listContainsModel->where('idShoppingList',$list['idShoppingList'])->findAll();
            foreach ($listContains as $contains){
                $listContainsModel->delete($contains['idListContains']);
            }
            $shoppingListModel->delete($list['idShoppingList']);
        }

        $notificationModel = new NotificationModel();
        $notifications = $notificationModel->where('idGroup',$idGroup)->where('type','0')->findAll();
        foreach ($notifications as $notification){
            $notificationModel->delete($notification['idNotification']);
        }

        $groupModel->delete($idGroup);
        return redirect()->to('/group/index');
        //$this->index();
    }

}
