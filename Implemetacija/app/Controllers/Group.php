<?php

namespace App\Controllers;

use App\Models\GroupModel;
use App\Models\InGroupModel;
use CodeIgniter\Model;

class Group extends BaseController
{
    public function index()
    {
        $groupModel = new GroupModel();
        $inGroup = new InGroupModel();
        $user = $this->session->get('user');

        $groups = $inGroup->findUsersGroups($user['idUser']);
        $groups = $groupModel->findAll();

        echo view('common/header');
        echo view('Views/groups/groups',['groups'=>$groups]);
        echo view('common/footer');
    }

    public function renderNewGroup()
    {
        echo view('common/header');
        echo view('groups/newGroup');
        echo view('common/footer');
    }

    public function editGroup()
    {
        echo view('common/header');
        echo view('groups/editGroup1');
        echo view('common/footer');
    }

    public function viewGroup()
    {
        echo view('common/header');
        echo view('groups/singleGroup1');
        echo view('common/footer');
    }

    public function newGroup() {
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'image'=>$this->request->getPost('image')
        ];

        $groupModel = new GroupModel();
        $groupModel->save($data);
    }
}
