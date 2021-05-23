<?php


namespace App\Controllers;


use App\Models\GroupModel;
use App\Models\InGroupModel;
use App\Models\ShopChainModel;
use App\Models\ShoppingListModel;
use App\Models\UserModel;

class Lists extends BaseController
{
    public function render()
    {
        $inGroupModel = new InGroupModel();
        $groupModel = new GroupModel();
        $shoppingListModel = new ShoppingListModel();

        $ingroups = $inGroupModel->findByUserId($this->session->get('user')['idUser']);
        $groupNames = [];
        $userGroups = [];

        foreach ($ingroups as $ingroup) {
            $idGroup = $ingroup['idGroup'];
            $group = $groupModel->find($idGroup);
            $groupNames[$idGroup] = $group['name'];
            $groupListRaw = $shoppingListModel->where('idGroup', $idGroup)->
                                                where('active', 1)->
                                                get()->getResultArray();

            $groupList = [];
            foreach ($groupListRaw as $list) {
                $groupList[$list['idShoppingList']] = $list['name'];
            }

            $userGroups[$idGroup] = $groupList;
        }


        echo view('common/header', []);
        echo view('lists/all_lists', ['userGroups' => $userGroups,
                                            'groupNames' => $groupNames]);
        echo view('common/footer', []);
    }


    public function index()
    {
        $this->render();
    }

    public function renderCreate($groupId, $errors = null)
    {
//        $userCurrent = new UserModel();
//        $this->session->set('user', $userCurrent->findByUsername('Bodin'));

        $user = $this->session->get('user');

        $groupModel = new GroupModel();
        $group = $groupModel->find($groupId);
        if ($group == null) {
            die("Invalid api call");
        }

        $ingroup = $groupModel->db()->table('ingroup')->where('idGroup', $groupId)->where('idUser', $user['idUser'])->get();
        if ($ingroup->getNumRows() == 0) {
            die("User not in group");
        }

        $shoppingChainModel = new ShopChainModel();
        $allShopChains = $shoppingChainModel->get()->getResultArray();
        foreach ($allShopChains as $shop) {
            $shops[$shop['idShopChain']] = $shop['name'];
        }

        ksort($shops);

        echo view('common/header', []);
        echo view('lists/create_list', ['group_name' => $group['name'],
                                                'group_id' => $groupId,
                                                'shops' => $shops,
                                                'errors' => $errors]);

        echo view('common/footer', []);
    }

    public function createNew() {
        $listModel = new ShoppingListModel();
        $listName = $this->request->getPost('list_name');
        $shopId = $this->request->getPost('shop_id');
        $groupId = $this->request->getPost('group');

        $groupModel = new GroupModel();
        if ($groupModel->find($groupId) == null) {
            die("Parameter failure");
        }

        $shoppChainModel = new ShopChainModel();
        if ($shoppChainModel->find($shopId) == null) {
            die("Parameter failure");
        }

        $data = [
            'name' => $listName,
            'active' => 1,
            'idShop' => $shopId,
            'idGroup' => $groupId,
        ];

        if(!$listModel->insert($data)) {
            $this->renderCreate($groupId, $listModel->errors());
            echo 1;
        }

        return redirect()->to('/lists/index');
    }
}