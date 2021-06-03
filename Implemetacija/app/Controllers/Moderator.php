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
    /**
     * @var array - podaci koji se prosledjuju u Moderator View
     */
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
        echo view("common/footer");
    }

    /**
     * Dodavanje nove prodavnice
     *
     * @param $shopName - naziv nove prodavnice
     * @return \CodeIgniter\HTTP\RedirectResponse
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

        echo view("common/moderator_header");
        echo view('moderator_new_item', $this->data);
        echo view("common/footer");
    }

    /**
     * Dodavanje novog Item-a post zahtevom
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function addItem()
    {
        if(!$this->session->has('user'))
            return redirect()->to('/login/index');
        $user = $this->session->get('user');
        if($user['type'] != ADMIN)
            return redirect()->to('/homePage/index');

        $itemModel = new ItemModel();
        $data = [
            'name' => $this->request->getVar('item_name'),
            'quantity' => $this->request->getVar('qty'),
            'metrics' => $this->request->getVar('measure'),
            'image' => null,
            'isCenoteka' => 0,
        ];
        // /assets/images/articles

        $shopId = $this->request->getVar('Shops');
        $category = $this->request->getVar('category');

        if($this->request->getFile('image')->getName() != "") {
            $time_unique = strtotime("now");
            $this->request->getFile('image')->move(ROOTPATH . 'public\uploads\items\assets\images\articles\\' . $time_unique, $this->request->getFile('image')->getName());
            $data['image'] = "/assets/images/articles/". $time_unique. "/". $this->request->getFile('image')->getName();
        } else
            $data['image'] = null;

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
