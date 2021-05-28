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

class Group extends BaseController
{
    public function index()
    {
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

        echo view('common/header');
        echo view('Views/groups/groups',['groups'=>$userGroups, 'ingroups'=>$ingroups]);
        echo view('common/footer');
    }

    public function renderNewGroup()
    {
        echo view('common/header');
        echo view('groups/newGroup');
        echo view('common/footer');
    }

    public function editGroup($id)
    {
        $name = $this->request->getPost('group_name');
        $description = $this->request->getPost('description');

        $groupModel = new GroupModel();

        $inGroupModel = new InGroupModel();
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

          $data['image'] = null;

        $groupModel->update($id,$data);

        return redirect()->to('/group/index');
    }

    public function renderEditGroup($id)
    {
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
            'inGroup'=>$inGroupUsers
        ];

        echo view('common/header');
        echo view('groups/editGroup1',$data);
        echo view('common/footer');
    }

    public function changeAdmin($groupId, $memberId){

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

    public function viewGroup($idGroup)
    {
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

        echo view('common/header');
        echo view('groups/singleGroup1',$data);
        echo view('common/footer');
    }

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

    private function getPopularItemsMonth($limit, $idGroup)
    {
        $listContainsModel = new ListContainsModel();
        $shoppingList = new ShoppingListModel();
        return $shoppingList->where('idGroup',$idGroup)
            ->join('listcontains','shoppinglist.idShoppingList = listcontains.idShoppingList')
            ->where('YEAR(bought)', date('m'))
            ->join('item', 'item.idItem = listcontains.idItem')
            ->select('listcontains.idItem AS idItem, item.name AS name, COUNT(listcontains.idItem) AS count')
            ->groupBy('listcontains.idItem')
            ->orderBy('count', "DESC")
            ->findAll($limit);
    }

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

    private function displayAsPie($popularItems)
    {
        $arrOfArr = [];
        foreach ($popularItems as $popularItem) {
            array_push($arrOfArr, [$popularItem['name'], (int)$popularItem['count']]);
        }
        return json_encode($arrOfArr);
    }

    public function addNewMember() {
        $username = $this->request->getPost('invite_member');

    }

    public function newGroup() {

        $htmlContent = file_get_contents(base_url("/Views/groups/newGroup.php"));

        $DOM = new DOMDocument();
        $DOM->loadHTML($htmlContent);

        $Detail = $DOM->getElementsByTagName('td');

        $i = 0;
        foreach($Detail as $sNodeDetail)
        {
            $membersToCall[$i] = trim($sNodeDetail->textContent);
            $i = $i + 1;
        }

        $name = $this->request->getPost('name');
        $desc = $this->request->getPost('description');
        $img = $this->request->getPost('image');

        if($name==null) $name="Unnamed group";

        $data = [
            'name'=>$name,
            'description'=>$desc,
        ];

 /*       if ($this->request->getFile('image')->getName() != "") {
            $time_unique = strtotime("now");
            $this->request->getFile('image')->move(ROOTPATH . 'public\uploads\\' . $time_unique, $this->request->getFile('image')->getName());
            $data['image'] = $time_unique . "/" . $this->request->getFile('image')->getName();
        } else
*/          $data['image'] = null;

        $groupModel = new GroupModel();
        $groupId = $groupModel->insert($data);

        $userId = $this->session->get('user')['idUser'];
        $this->joinGroup($userId,$groupId,1);



        $userModel = new UserModel();

        $j=0;

        $members=[];

         foreach($membersToCall as $member){
            $user = $userModel->findByUsername($member);
            if($user!=null) {
                $members[$j++] = $user;
            }
        }

         $group = $groupModel->find($groupId);

         $this->sendCall($members,$group);

        return redirect()->to('/group/index');
    }

    public function joinGroup($userId, $groupId,$type){
        $ingroupData = [
            'idUser'=>$userId,
            'idGroup'=>$groupId,
            'type'=>$type
        ];

        $ingroupModel = new InGroupModel();
        $ingroupModel->save($ingroupData);
    }

    public function sendCall($members,$group){
        $notificationModel = new NotificationModel();
        foreach($members as $member) {
            $data = [
                'idGroup' => $group['idGroup'],
                'idUser'=>$member['idUser'],
                'type'    => JOIN_GROUP_REQ['type'],
                'isRead'  => 0,
                'text'    => JOIN_GROUP_REQ['msg']. " ". $group['name'],
            ];
            $notificationModel->save($data);
        }
    }

    public function removeFromGroup($groupId, $userId){

        $groupModel = new GroupModel();
        $group = $groupModel->find($groupId);
        $myId = $this->session->get('user')['idUser'];
        if($myId==$userId) $this->leaveGroup($groupId);
        else{
            $inGroupModel = new InGroupModel();
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

            $path = 'group/renderEditGroup/'.$groupId;

            return redirect()->to($path);
        }
    }

    public function leaveGroup($groupId){

        $inGroupModel = new InGroupModel();
        $thisGroup = $inGroupModel->findByGroupId($groupId);

        $userId = $this->session->get('user')['idUser'];

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

        return redirect()->to('/group/index');
    }

    protected function deleteGroup($idGroup){

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
        $groupModel->delete($idGroup);

    }

}
