<?php


namespace App\Controllers;


use App\Models\CategoryModel;
use App\Models\GroupModel;
use App\Models\InGroupModel;
use App\Models\ItemCategoryModel;
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
        echo "DEPRECATED - REPORT BUG IMEDIATELY";
//        $shoppingListModel = new ShoppingListModel();
//        $listContainsModel = new ListContainsModel();
//        $itemPriceModel = new ItemPriceModel();
//        $itemModel = new ItemModel();
//        $shopChainModel = new ShopChainModel();
//
//        $shoppingList = $shoppingListModel->find($idShoppingList);
//        if ($shoppingList == null || $shoppingList['active'] == 0)
//        {
//            Error::show("List not found");
//        }
//        $this->checkLegal($shoppingList);
//
//        $itemsListContain = $listContainsModel->findAllInList($idShoppingList);
//        $itemsList = [];
//
//        foreach ($itemsListContain as $contained)
//        {
//            $item = $itemModel->find($contained['idItem']);
//            $bought = $contained['bought'];
//
//            $itemPrice = $itemPriceModel->where('idItem', $item['idItem'])->
//            where('idShopChain', $shoppingList['idShop'])->
//            first();
//            if ($itemPrice == null)
//            {
//                $price = 'N/A';
//            }
//            else
//            {
//                $price = $itemPrice['price'];
//            }
//            //echo $price;
//
//            $itemDesc = [$item['name'], $item['quantity'].' '.$item['metrics'], $bought, $contained['idListContains'], $price, $contained['idListContains']];
//            array_push($itemsList, $itemDesc);
//        }
//
//        $shop = $shopChainModel->find($shoppingList['idShop']);
//        $shops = $shopChainModel->findAll();
//
//        echo view("common/header");
//        echo view("lists/edit_list", ['listName' => $shoppingList['name'],
//            'id' => $idShoppingList,
//            'items' => $itemsList,
//            'listId' => $shoppingList['idShoppingList'],
//            'shop' => $shop['name'],
//            'shops' => $shops
//        ]);
//        echo view("common/footer");
    }

    public function changeShop($listId, $shopId){
        $listModel = new ShoppingListModel();
        $list = $listModel->find($listId);
        if ($list == null || $list['active'] == 0)
        {
            Error::show("List not found");
        }
        $this->checkLegal($list);
        $shopModel = new ShopChainModel();
        $shop = $shopModel->find($shopId);
        if($shop == null)
        {
            Error::show("Shop not found");
        }
        $data = [
            'idGroup' => $list['idGroup'],
            'name' => $list['name'],
            'idShop' => $shopId,
            'active' => $list['active'],
            'createdAt' => $list['createdAt']
        ];
        $listModel->update($listId, $data);
        return redirect()->to("/lists/shopping/".$listId);
    }

    public function renderCategory($listId, $idCategory, $idListContains = null)
    {
        $category = (new CategoryModel())->find($idCategory);
        if ($category == null)
        {
            Error::show("Category not found");
        }
        $name = (new CategoryModel())->find($idCategory)['name'];
        $itemModel = new ItemModel();
        $itemPriceModel = new ItemPriceModel();
        $itemCategoryModel = new ItemCategoryModel();
        $listModel = new ShoppingListModel();

        $list = $listModel->find($listId);
        if ($list == null || $list['active'] == 0)
        {
            Error::show("List not found");
        }
        $this->checkLegal($list);

        $cenotekaItems = $itemCategoryModel->where('idCategory', $idCategory)->find();

        $items = [];
        foreach ($cenotekaItems as $cenotekaItem){
            $el = [$cenotekaItem];
            $scnd = $itemModel->find($cenotekaItem['idItem']);
            $price = $itemPriceModel->where('idItem', $cenotekaItem['idItem'])
                ->where('idShopChain', $list['idShop'])->first()['price'];
            array_push($el, $scnd);
            array_push($el, $price);
            array_push($items, $el);
        }

        echo view("common/header");
        echo view("lists/select", ['idListContains' => $idListContains,
            'idCategory' => $idCategory,
            'cenotekaItems' => $items,
            'categoryName' => $name,
            'listId' => $listId
        ]);
        echo view("common/footer");
    }

    public function editItem($idListContained, $idList)
    {
        $listContainsModel = new ListContainsModel();
        $itemModel = new ItemModel();
        $listModel = new ShoppingListModel();
        $list = $listModel->find($idList);
        if ($list == null || $list['active'] == 0)
        {
            Error::show("List not found");
        }
        $this->checkLegal($list);

        $listContains = $listContainsModel->find($idListContained);
        if ($listContains == null)
        {
            Error::show("Item not found");
        }
        $item = $itemModel->find($listContains['idItem']);

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->findAll();

        echo view("common/header");
        echo view("lists/edit_item", ['idListContained' => $idListContained,
            'id' => $item["idItem"],
            'idList' => $idList,
            'name' => $item['name'],
            'quantity' => $item['quantity'],
            'categories' => $categories
        ]);
        echo view("common/footer");
    }

    public function addItemRender($idList)
    {
        $listModel = new ShoppingListModel();
        $list = $listModel->find($idList);
        if ($list == null || $list['active'] == 0)
        {
            Error::show("List not found");
        }

        $categoriesModel = new CategoryModel();
        $categories = $categoriesModel->findAll();

        echo view("common/header");
        echo view("lists/new_item", [
            'idList' => $idList,
            'categories' => $categories
        ]);
        echo view("common/footer");
    }

    public function addItem($name, $quantity, $measure, $listId)
    {
        $user = $this->session->get('user');

        $listModel = new ShoppingListModel();
        $list = $listModel->find($listId);
        if ($list == null || $list['active'] == 0)
        {
            Error::show("List not found");
        }
        $this->checkLegal($list);

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
            'bought' => null,
            'idUser' => $user['idUser']
        ];
        $listContainsModel->insert($data1);

        return redirect()->to('/lists/shopping/'.$listId);
    }

    public function addCenotekaItem($listId, $itemId)
    {
        $user = $this->session->get('user');
        $listModel = new ShoppingListModel();
        $list = $listModel->find($listId);
        if ($list == null || $list['active'] == 0)
        {
            Error::show("List not found");
        }
        $this->checkLegal($list);
        $itemModel = new ItemModel();
        $item = $itemModel->find($itemId);
        if ($item == null)
        {
            Error::show("Item not found");
        }

        $listContainsModel = new ListContainsModel();
        $data=[
            'idShoppingList' => $listId,
            'idItem' => $itemId,
            'idUser' => $user['idUser']
        ];
        $listContainsModel->insert($data);
        return redirect()->to('/lists/shopping/'.$listId);
    }

    public function changeCenotekaItem($listId, $itemId, $listContains)
    {
        $listModel = new ShoppingListModel();
        $list = $listModel->find($listId);
        if ($list == null || $list['active'] == 0)
        {
            Error::show("List not found");
        }

        $this->checkLegal($list);
        $itemModel = new ItemModel();
        $item = $listModel->find($itemId);
        if ($item == null)
        {
            Error::show("Item not found");
        }
        $listContainsModel = new ListContainsModel();
        $itemtd = $listContainsModel->find($listContains);
        if($itemtd == null)
        {
            Error::show("Item not found");
        }
        $toDel = $itemtd['idItem'];
        $item = $itemModel->find($toDel);
        $listContainsModel->delete($listContains);
        if($item['isCenoteka'] != 1)
            $itemModel->delete($toDel);
        return $this->addCenotekaItem($listId, $itemId);
    }

    public function deleteItem($idListContains, $listId)
    {
        $listModel = new ShoppingListModel();
        $list = $listModel->find($listId);
        if ($list == null || $list['active'] == 0)
        {
            Error::show("List not found");
        }
        $this->checkLegal($list);
        $listContainsModel = new ListContainsModel();
        $listContains = $listContainsModel->find($idListContains);
        if ($listContains == null)
        {
            Error::show("List not found");
        }
        $itemModel = new ItemModel();
        $itemId = $listContains['idItem'];
        $item = $itemModel->find($listContains['idItem']);
        $itemsListContain = $listContainsModel->delete($idListContains);
        if($item['isCenoteka']!=1)
            $itemModel->delete($itemId);
        return redirect()->to('/lists/shopping/'.$listId);
    }

    public function changeItem($idListContains, $itemId, $name, $quantity, $measure, $listId)
    {
        $listModel = new ShoppingListModel();
        $list = $listModel->find($listId);
        if ($list == null || $list['active'] == 0)
        {
            Error::show("List not found");
        }
        $this->checkLegal($list);
        $itemModel = new ItemModel();
        $item = $itemModel->find($itemId);
        if ($item == null)
        {
            Error::show("List not found");
        }
        $listContainsModel = new ListContainsModel();
        $listContains = $listContainsModel->find($idListContains);
        if ($listContains == null)
        {
            Error::show("List not found");
        }
        $data = [
            'name' => $name,
            'quantity' => $quantity,
            'metrics' => $measure,
            'idItem' => $itemId,
            'isCenoteka' => null
        ];
        if($item['isCenoteka']==1) {
            $listContainsModel->delete($idListContains);
            return $this->addItem($name, $quantity, $measure, $listId);
        }
        $itemModel->update($itemId, $data);
        return redirect()->to('/lists/shopping/'.$listId);
    }

    public function renderCreate($groupId, $errors = null)
    {
        $user = $this->session->get('user');

        $groupModel = new GroupModel();
        $group = $groupModel->find($groupId);
        if ($group == null) {
            Error::show("Invalid api call");
        }

        $ingroup = $groupModel->db()->table('ingroup')->where('idGroup', $groupId)->where('idUser', $user['idUser'])->get();
        if ($ingroup->getNumRows() == 0) {
            Error::show("User not in group");
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
        $shopId = $this->request->getPost('shopid');
        $groupId = $this->request->getPost('group');

        if($shopId == null){
            Error::show("Parameter failure");
        }

        $listModel = new ShoppingListModel();
        $groupModel = new GroupModel();
        if ($groupModel->find($groupId) == null) {
            Error::show("Parameter failure");
        }

        $shoppChainModel = new ShopChainModel();
        if ($shoppChainModel->find($shopId) == null) {
            Error::show("Parameter failure");
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
        $shoppChainModel = new ShopChainModel();

        $all_shop_chains = $shoppChainModel->findAll();

        $shoppingList = $shoppingListModel->find($idShoppingList);
        if ($shoppingList == null || $shoppingList['active'] == 0)
        {
            Error::show("List not found");
        }

        $this->checkLegal($shoppingList);

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

        $listShop = $shoppChainModel->find($shoppingList['idShop']);
        $shopName = '';
        if ($listShop == null || $shoppingList['idShop'] == null) {
            $shopName = '';
        }
        else {
            $shopName = $listShop['name'];
        }

        echo view("common/header");
        echo view("lists/shopping", ['listName' => $shoppingList['name'],
                                            'items' => $itemsList,
                                            'listId' => $shoppingList['idShoppingList'],
                                            'writable' => 1,
                                            'shops' => $all_shop_chains,
                                            'shop' => $shopName,
                                            'id' => $idShoppingList,
                                            ]);
        echo view("common/footer");
    }

    public function bought($idListContains, $state)
    {
        $listContainsModel = new ListContainsModel();
        $listContains = $listContainsModel->find($idListContains);
        if ($listContains == null)
        {
            Error::show("Item not found");
        }
        if ($state == 'null')
        {
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
            Error::show("Invalid api call");
        }

        $this->checkLegal($shoppingList);

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
                Error::show('List not saved');
            }

            $listContainsModel = new ListContainsModel();
            $listContainsToUpdate = $listContainsModel->where('idShoppingList', $idShoppingList)->
                                                        where('bought', null)->find();
            foreach ($listContainsToUpdate as $listContains)
            {
                $listContains['idShoppingList'] = $newListId;
                if (!$listContainsModel->update($listContains['idListContains'], $listContains))
                {
                    Error::show('Server error');
                }
            }
        }

        $shoppingList['active'] = 0;
        if (!$shoppingListModel->update($idShoppingList, $shoppingList))
        {
            Error::show("Server error");
        }

        return redirect()->to('/lists/index');
    }

    public function deleteList($listId)
    {
        $listModel = new ShoppingListModel();
        $list = $listModel->find($listId);
        if ($list == null || $list['active'] == 0)
        {
            Error::show("List not found");
        }
        $this->checkLegal($list);
        $listModel = new ShoppingListModel();
        $itemModel = new ItemModel();
        $listContainsModel = new ListContainsModel();
        $listConatinsList = $listContainsModel->findAll();
        foreach($listConatinsList as $listContains)
        {
            if($listContains['idShoppingList'] == $listId) {
                $itemId = $listContains['idItem'];
                $listContainsModel->delete($listContains['idListContains']);
                if($itemModel->find($itemId)['isCenoteka']!=1)
                    $itemModel->delete($itemId);
            }
        }
        $listModel->delete($listId);
        return redirect()->to('/lists/index');
    }

    public function createLink($listId)
    {
        $linkModel = new LinkModel();
        $shoppingListModel = new ShoppingListModel();

        if (!$shoppingListModel->find($listId))
        {
            Error::show("No shopping list found");
        }
        $this->checkLegal($shoppingListModel->find($listId));

        $link = $this->request->getPost('link');
        $perm = $this->request->getPost('perm');

        if ($link == null || $perm == null)
        {
            Error::show("Wrong api call".$link.' '.$perm);
        }

        $link = str_replace(base_url().'/guest/guest/', '', $link);

        $data = [
            'link' => $link,
            'writable' => $perm,
            'idShoppingList' => $listId
        ];

        if (!$linkModel->insert($data))
        {
            Error::show("Server error".$linkModel->errors());
        }
    }

    public function checkLegal($list)
    {
        $ingroupModel = new InGroupModel();
        $thisuser = $ingroupModel->where('idGroup', $list['idGroup'])->where('idUser', $this->session->get('user')['idUser'])->first();
        if($thisuser == null)
        {
            Error::show('Illegal request');
        }
    }
}