<?php


namespace App\Controllers;


use App\Models\GroupModel;
use App\Models\InGroupModel;
use App\Models\ItemModel;
use App\Models\ItemPriceModel;
use App\Models\LinkModel;
use App\Models\ListContainsModel;
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

    public function renderList($idShoppingList, $errors = null)
    {
        $shoppingListModel = new ShoppingListModel();
        $listContainsModel = new ListContainsModel();
        $itemPriceModel = new ItemPriceModel();
        $itemModel = new ItemModel();
        $shopChainModel = new ShopChainModel();

        $shoppingList = $shoppingListModel->find($idShoppingList);
        if ($shoppingList == null || $shoppingList['active'] == 0)
        {
            die("List not found");
        }

        $itemsListContain = $listContainsModel->findAllInList($idShoppingList);
        $itemsList = [];

        foreach ($itemsListContain as $contained)
        {
            $item = $itemModel->find($contained['idItem']);
            $bought = $contained['bought'];

            $itemPrice = $itemPriceModel->where('idItem', $item['idItem'])->
            where('idShopChain', $shoppingList['idShop'])->
            first();
            if ($itemPrice == null)
            {
                $price = 'N/A';
            }
            else
            {
                $price = $itemPrice['price'];
            }
            //echo $price;

            $itemDesc = [$item['name'], $item['quantity'].' '.$item['metrics'], $bought, $contained['idListContains'], $price, $contained['idListContains']];
            array_push($itemsList, $itemDesc);
        }

        $shop = $shopChainModel->find($shoppingList['idShop']);

        echo view("common/header");
        echo view("lists/edit_list", ['listName' => $shoppingList['name'],
            'id' => $idShoppingList,
            'items' => $itemsList,
            'listId' => $shoppingList['idShoppingList'],
            'shop' => $shop['name']
        ]);
        echo view("common/footer");
    }

    public function editItem($idListContained, $idList)
    {
        $listContainsModel = new ListContainsModel();
        $itemModel = new ItemModel();

        $listContains = $listContainsModel->find($idListContained);
        $item = $itemModel->find($listContains['idItem']);

        echo view("common/header");
        echo view("lists/edit_item", ['idListContained' => $idListContained,
            'id' => $item["idItem"],
            'idList' => $idList,
            'name' => $item['name'],
            'quantity' => $item['quantity']
        ]);
        echo view("common/footer");
    }

    public function addItemRender($idList)
    {
        echo view("common/header");
        echo view("lists/new_item", [
            'idList' => $idList
        ]);
        echo view("common/footer");
    }

    public function addItem($name, $quantity, $measure, $listId)
    {
        $user = $this->session->get('user');
        $itemModel = new ItemModel();
        $data = [
            'name' => $name,
            'quantity' => $quantity,
            'metrics' => $measure
        ];
        $newid = $itemModel->insert($data);

        $listContainsModel = new ListContainsModel();
        $data1 = ['idShoppingList' => $listId,
            'idItem' => $newid,
            'bought' => date("Y-m-d"),
            'idUser' => $user["idUser"]
        ];
        $listContainsModel->insert($data1);

        return redirect()->to('/lists/renderList/'.$listId);
    }

    public function deleteItem($idListContains, $listId)
    {
        $listContainsModel = new ListContainsModel();
        $itemsListContain = $listContainsModel->delete($idListContains);
        return redirect()->to('/lists/renderList/'.$listId);
    }

    public function changeItem($itemId, $name, $quantity, $measure, $listId)
    {
        $itemModel = new ItemModel();
        $item = $itemModel->find($itemId);
        $item['name'] = $name;
        $item['quantity'] = $quantity;
        $item['metrics'] = $measure;
        $data = [
            'name' => $name,
            'quantity' => $quantity,
            'metrics' => $measure,
            'idItem' => $itemId
        ];
        $itemModel->update($itemId, $data);
        return redirect()->to('/lists/renderList/'.$listId);
    }

    public function renderCreate($groupId, $errors = null)
    {
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

    public function createNew()
    {
        $listName = $this->request->getPost('list_name');
        $shopId = $this->request->getPost('shop_id');
        $groupId = $this->request->getPost('group');

        $listModel = new ShoppingListModel();
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
        }

        return redirect()->to('/lists/index');
    }

    public function shopping($idShoppingList)
    {
        $shoppingListModel = new ShoppingListModel();
        $listContainsModel = new ListContainsModel();
        $itemPriceModel = new ItemPriceModel();
        $itemModel = new ItemModel();

        $shoppingList = $shoppingListModel->find($idShoppingList);
        if ($shoppingList == null || $shoppingList['active'] == 0)
        {
            die("List not found");
        }

        $itemsListContain = $listContainsModel->findAllInList($idShoppingList);
        $itemsList = [];

        foreach ($itemsListContain as $contained)
        {
            $item = $itemModel->find($contained['idItem']);
            $bought = $contained['bought'];

            $itemPrice = $itemPriceModel->where('idItem', $item['idItem'])->
                                        where('idShopChain', $shoppingList['idShop'])->
                                        first();
            if ($itemPrice == null)
            {
                $price = 'N/A';
            }
            else
            {
                $price = $itemPrice['price'];
            }

            $itemDesc = [$item['name'], $item['quantity'].' '.$item['metrics'], $bought, $contained['idListContains'], $price];
            array_push($itemsList, $itemDesc);
        }

        echo view("common/header");
        echo view("lists/shopping", ['listName' => $shoppingList['name'],
                                            'items' => $itemsList,
                                            'listId' => $shoppingList['idShoppingList'],
                                            'writable' => 1,
                                            ]);
        echo view("common/footer");
    }

    public function bought($idListContains, $state)
    {
        $listContainsModel = new ListContainsModel();
        $listContains = $listContainsModel->find($idListContains);
        if ($listContains == null)
        {
            die ("Item not found");
        }
        if ($state == 'null')
        {
            echo 'done';
            $listContains['bought'] = null;
        }
        else
        {
            $listContains['bought'] = date('Y-m-d');
        }

        if (!$listContainsModel->update($idListContains, $listContains))
        {
            echo implode(' ', $listContainsModel->errors());
        }
    }

    public function finish($idShoppingList, $createNewList)
    {
        $shoppingListModel = new ShoppingListModel();

        $shoppingList = $shoppingListModel->find($idShoppingList);
        if ($shoppingList == null)
        {
            die("Invalid api call");
        }

        if ($createNewList == 'yes')
        {
            $data = [
                'name' => $shoppingList['name'],
                'active' => 1,
                'idShop' => $shoppingList['idShop'],
                'idGroup' => $shoppingList['idGroup'],
            ];

            $newListId = $shoppingListModel->insert($data);
            if ($newListId == null)
            {
                die('List not saved');
            }

            $listContainsModel = new ListContainsModel();
            $listContainsToUpdate = $listContainsModel->where('idShoppingList', $idShoppingList)->
                                                        where('bought', null)->find();
            foreach ($listContainsToUpdate as $listContains)
            {
                $listContains['idShoppingList'] = $newListId;
                if (!$listContainsModel->update($listContains['idListContains'], $listContains))
                {
                    die('Server error');
                }
            }
        }

        $shoppingList['active'] = 0;
        if (!$shoppingListModel->update($idShoppingList, $shoppingList))
        {
            die("Server error");
        }

        return redirect()->to('/lists/index');
    }

    public function createLink($listId)
    {
        $linkModel = new LinkModel();
        $shoppingListModel = new ShoppingListModel();

        if (!$shoppingListModel->find($listId))
        {
            die("No shopping list found");
        }

        $link = $this->request->getPost('link');
        $perm = $this->request->getPost('perm');

        if ($link == null || $perm == null)
        {
            die("Wrong api call".$link.' '.$perm);
        }

        $link = str_replace(base_url().'/guest/guest/', '', $link);

        $data = [
            'link' => $link,
            'writable' => $perm,
            'idShoppingList' => $listId
        ];

        if (!$linkModel->insert($data))
        {
            die("Server error".$linkModel->errors());
        }

        echo "datatatatat";
    }
}