<?php

/**
 * Authors - Olga Maslarevic 0007/2018 i Andrej Gobeljic 0019/2018
 */

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ItemCategoryModel;
use App\Models\ItemModel;
use App\Models\ItemPriceModel;
use App\Models\ShopChainModel;
use App\Models\UserModel;
use CodeIgniter\CodeIgniter;

define("ADMIN", 0);

/**
 * Class Moderator - klasa zaduzena za upravljanje stranicama moderatora i omogucajvanje upravljanjem bazom
 *
 * @package App\Controllers
 * @version 1.0
 */
class Moderator extends BaseController
{

    private $data = [];
    private $idItem;

    /**
     * Pomocna funkcija za dohvatanje svih prodavnica
     *
     * @param void
     * @return void
     */
    private function getShopNames()
    {
        $shopChainModel = new ShopChainModel();
        $shops = $shopChainModel->findAll();

        $this->data['shops'] = $shops;
    }

    /**
     * Promena cene jednog Item-a
     *
     * @param void
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function changePrice()
    {
        $idItem = (int)($this->request->getUri()->getSegment(3));
        $newPrice = $this->request->getUri()->getSegment(4);

        $priceModel = new ItemPriceModel();
        $priceModel->update($idItem, ['price' => $newPrice]);

        return redirect()->to("/moderator/index/");
    }

    /**
     * Dohvatanje svih Item-a za jednu prodavnicu na osnovu pretrage po imenu
     *
     * @param $idShop - id prodavnice
     * @param $name - pretraga
     * @return void
     */
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

    /**
     * Promena sifre
     *
     * @param $new_pass - nova sifra
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function refreshPassword($new_pass) {

        $user = $this->session->get('user');
        $user['password'] = $new_pass;

        (new UserModel())->update($user['idUser'], $user);
        return redirect()->back();
    }

    /**
     * Prikaz pocetne stranice
     *
     * @param void
     * @return void
     */
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

    /**
     * Dodavanje nove prodavnice
     *
     * @param $shopName - naziv nove prodavnice
     * @return void
     */
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

    /**
     * Prikazivanje stranice za dodavanje novog Item-a
     *
     * @param void
     * @return CodeIgniter\HTTP\RedirectResponse;
     */
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

        $categoriesModel = new CategoryModel();
        $categories = $categoriesModel->findAll();
        echo view("common/moderator_header");

        $this->data['allCategories'] = $categories;
        echo view('moderator_new_item', $this->data);
    }

    /**
     * Dodavanje novog Item-a
     *
     * @param $name - ime novog proizvoda
     * @param $measure - jedinica mere
     * @param $quantity - kolicina u jedinici mere
     * @param $category - kategorija novog proizvoda
     * @param $shopId - id prodavnice za koju se dodaje Item
     * @return CodeIgniter\HTTP\RedirectResponse
     */
    public function addItem($name, $measure, $quantity, $category, $shopId)
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
        $data = [
            'idCategory' => $category,
            'idItem' => $itemId
        ];
        (new ItemCategoryModel())->insert($data);
        return redirect()->to('/moderator/index');
    }

}
