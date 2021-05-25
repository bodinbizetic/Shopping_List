<?php

namespace App\Controllers;

use App\Models\GroupModel;
use App\Models\InGroupModel;
use App\Models\NotificationModel;
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

    public function editGroup($id){
        $name = $this->request->getPost('group_name');
        $description = $this->request->getPost('description');
        $image = $this->request->getPost('image');

        $groupModel = new GroupModel();

        $data = [
            'name'=>$name,
            'description'=>$description,
            'image'=>$image
        ];
        $groupModel->update($id,$data);

        return redirect()->to('/group/index');
    }

    public function renderEditGroup($id)
    {
        $userModel = new UserModel();
        $inGroupModel = new InGroupModel();
        $inGroupUsers = $inGroupModel->where('groupId',$id);


        $members = [];
        $i=0;

        foreach ($inGroupUsers as $inGroupUser){
            $user = $userModel->find($inGroupUser);
            $members[$i++]=$user;
        }

        $groupModel = new GroupModel();
        $group = $groupModel->find($id);

        echo view('common/header');
        echo view('groups/editGroup1',['members'=>$members, 'name'=>$group['name'], 'description'=>$group['description'],
            'image'=>$group['image'],'ingroup'=>$inGroupUsers, 'groupId'=>$group['idGroup']]);
        echo view('common/footer');
    }

    public function viewGroup()
    {
        echo view('common/header');
        echo view('groups/singleGroup1');
        echo view('common/footer');
    }

    public function addNewMember() {
        $username = $this->request->getPost('invite_member');

    }

    public function newGroup() {
        $name = $this->request->getPost('name');
        $desc = $this->request->getPost('description');
        $img = $this->request->getPost('image');

        if($name==null) $name="Unnamed group";
        if($img=="") $img=null;

        $data = [
            'name' => $name,
            'description' => $desc,
            'image'=>$img
        ];

        $groupModel = new GroupModel();
        $groupId = $groupModel->insert($data);

        $userId = $this->session->get('user')['idUser'];
        $this->joinGroup($userId,$groupId,1);

        $memberToCall = $this->request->getPost('invite_members');

        $userModel = new UserModel();

        $membersUserName = explode(";",$memberToCall);

        $j=0;

        $members=[];

         foreach($membersUserName as $member){
            $user = $userModel->findByUsername($membersUserName);
            $members[$j++]=$user;
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
}
