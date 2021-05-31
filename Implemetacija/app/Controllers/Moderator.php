<?php

namespace App\Controllers;

use App\Models\ItemModel;
use App\Models\ItemPriceModel;
use App\Models\ShopChainModel;
use App\Models\UserModel;

define("ADMIN", 0);


class Moderator extends BaseController
{

    private $data = [];
    private $idItem;

    private function getShopNames()
    {
        $shopChainModel = new ShopChainModel();
        $shops = $shopChainModel->findAll();

        $this->data['shops'] = $shops;
    }

    public function changePrice()
    {
        $idItem = (int)($this->request->getUri()->getSegment(3));
        $newPrice = $this->request->getUri()->getSegment(4);

        $priceModel = new ItemPriceModel();
        $priceModel->update($idItem, ['price' => $newPrice]);

        return redirect()->to("/moderator/index/");
    }

    private function getAllItems($idShop, $name)
    {
        $itemPriceModel = new ItemPriceModel();
        if(!$idShop)
            $items = $itemPriceModel->select("*")
                ->join('item', 'item.idItem = itemprice.idItem')
                ->like('item.name', '%'.$name.'%')
                ->join('shopchain', 'shopchain.idShopChain = itemprice.idShopChain')
                ->select("item.name as itemName, itemprice.price as price, shopchain.name as shopName")
                ->paginate(10,'moderator');
        else
            $items = $itemPriceModel->select("*")->where("itemprice.idShopChain", $idShop)
                ->join('item', 'item.idItem = itemprice.idItem')
                ->like('item.name', '%'.$name.'%')
                ->join('shopchain', 'shopchain.idShopChain = itemprice.idShopChain')
                ->select("item.name as itemName, itemprice.price as price, shopchain.name as shopName")
                ->paginate(10, 'moderator');

        $pager = $itemPriceModel->pager;

        $this->data['items'] = $items;
        $this->data['pager'] = $pager;
    }

    public function refreshPassword($new_pass) {

        $user = $this->session->get('user');
        $user['password'] = $new_pass;

        (new UserModel())->update($user['idUser'], $user);
        return redirect()->back();
    }

    public function index()
    {
        if(!$this->session->has('user'))
            return redirect()->to('/login/index');
        $user = $this->session->get('user');
        if($user['type'] != ADMIN)
            return redirect()->to('/homePage/index');

        $shopId = $this->request->getVar('Shops');
        $name = $this->request->getVar('item-name');

        $this->getShopNames();
        $this->getAllItems($shopId, $name);


        echo view("common/moderator_header");
        echo view('moderator', $this->data);
    }

    public function addShop($shopName)
    {
        if(!$this->session->has('user'))
            return redirect()->to('/login/index');
        $user = $this->session->get('user');
        if($user['type'] != ADMIN)
            return redirect()->to('/homePage/index');

        $shopChainModel = new ShopChainModel();
        $data = [
            'name' => $shopName
        ];
        $shopChainModel->insert($data);
        return redirect()->back();
    }

    public function renderAddItem()
    {
        if(!$this->session->has('user'))
            return redirect()->to('/login/index');
        $user = $this->session->get('user');
        if($user['type'] != ADMIN)
            return redirect()->to('/homePage/index');

        $shopId = $this->request->getVar('Shops');
        $name = $this->request->getVar('item-name');

        $this->getShopNames();
        $this->getAllItems($shopId, $name);

        echo view("common/moderator_header");
        echo view('moderator_new_item', $this->data);
    }

    public function addItem($name, $measure, $quantity, $shopId)
    {
        if(!$this->session->has('user'))
            return redirect()->to('/login/index');
        $user = $this->session->get('user');
        if($user['type'] != ADMIN)
            return redirect()->to('/homePage/index');

        $itemModel = new ItemModel();
        $data = [
            'name' => $name,
            'quantity' => $quantity,
            'metrics' => $measure,
            'image' => null,
            'isCenoteka' => 1
        ];
        $itemId = $itemModel->insert($data);
        $data = [
            'idShopChain' => $shopId,
            'price' => 0,
            'idItem' => $itemId
        ];
        (new ItemPriceModel())->insert($data);
        return redirect()->to('/moderator/index');
    }

}
