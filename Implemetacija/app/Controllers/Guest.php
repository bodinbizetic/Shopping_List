<?php
/**
 * Author - Bodin Bizetic 0058/2018
 */
namespace App\Controllers;


use App\Models\ItemModel;
use App\Models\ItemPriceModel;
use App\Models\LinkModel;
use App\Models\ListContainsModel;
use App\Models\ShopChainModel;
use App\Models\ShoppingListModel;

/**
 * Guest - klasa za upucivanje korisnika gosta na odgovarajucu stranicu
 *
 * @version 1.0
 */
class Guest extends BaseController
{
    /**
     * Preusmerava gosta na stranicu za listu na koju ukazuje $pageLink
     *
     * @param $pageLink - skriveni identifikator ShoppingList stranice
     */
    public function guest($pageLink)
    {
        $linkModal = new LinkModel();
        $shoppingListModel = new ShoppingListModel();
        $listContainsModel = new ListContainsModel();
        $itemModel = new ItemModel();
        $itemPriceModel = new ItemPriceModel();

        $link = $linkModal->where('link', $pageLink)->first();
        if ($link == null)
        {
            Error::show("Wrong link supplied");
        }

        $shoppingList = $shoppingListModel->find($link['idShoppingList']);
        if ($shoppingList == null)
        {
            Error::show("Server error");
        }

        if ($shoppingList['active'] == 0)
        {
            $link['writable'] = 0;
        }

        $idShoppingList = $link['idShoppingList'];
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

        $shoppChainModel = new ShopChainModel();
        $all_shop_chains = $shoppChainModel->findAll();
        $listShop = $shoppChainModel->find($shoppingList['idShop']);
        $shopName = '';
        if ($listShop == null || $shoppingList['idShop'] == null) {
            $shopName = '';
        }
        else {
            $shopName = $listShop['name'];
        }

        if ($this->session->get('user') == null)
            echo view('lists/guest_header');
        else
            echo view('common/header');
        if ($link['writable'] == 0) {
            echo view("lists/guest", ['listName' => $shoppingList['name'],
                'items' => $itemsList,
                'listId' => $shoppingList['idShoppingList'],
                'writable' => $link['writable'],
            ]);
        } else {
            echo view("lists/shopping", ['listName' => $shoppingList['name'],
                'items' => $itemsList,
                'listId' => $shoppingList['idShoppingList'],
                'writable' => 1,
                'shops' => $all_shop_chains,
                'shop' => $shopName,
                'id' => $idShoppingList,
                'lists' => '',
            ]);
        }
        echo view('common/footer');
    }

}