<?php


namespace App\Controllers;


use App\Models\ItemModel;
use App\Models\ItemPriceModel;
use App\Models\LinkModel;
use App\Models\ListContainsModel;
use App\Models\ShoppingListModel;

class Guest extends BaseController
{
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
            die("Wrong link supplied");
        }

        $shoppingList = $shoppingListModel->find($link['idShoppingList']);
        if ($shoppingList == null)
        {
            die("Server error");
        }

        if ($shoppingList['active'] == 0)
        {
            die("Shopping list is not active anymore");
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

        echo view('lists/guest_header');
        echo view("lists/shopping", ['listName' => $shoppingList['name'],
                                            'items' => $itemsList,
                                            'listId' => $shoppingList['idShoppingList'],
                                            'writable' => $link['writable'],
                                            ]);
        echo view('common/footer');
    }

}