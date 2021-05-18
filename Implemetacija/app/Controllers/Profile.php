<?php

namespace App\Controllers;

use App\Models\ItemPriceModel;
use App\Models\ListContainsModel;
use App\Models\ShoppingListModel;

class Profile extends BaseController
{

    private function filterByPeriodBought($arr, $period) {
        if($period == "today")
            return array_filter($arr, function ($row) { return $row['bought'] == date("Y-m-d"); });
        if($period == "year")
            return array_filter($arr, function ($row) { $time = strtotime($row['bought']); return date("Y", $time) == date("Y", strtotime(date("Y-m-d"))); });
        return array_filter($arr, function ($row) { $time = strtotime($row['bought']); return date("F", $time) == date("F", strtotime(date("Y-m-d"))); });
    }

    private function filterByPeriodCreatedAt($arr, $period) {
        if($period == "today")
            return array_filter($arr, function ($row) {
                $time = strtotime($row['createdAt']);
                $today = strtotime(date("Y-m-d"));
                return date("D", $time) == date("D", $today) && date("F", $time) == date("F", $today) && date("Y", $time) == date("Y", $today) ;
            });
        if($period == "year")
            return array_filter($arr, function ($row) { $time = strtotime($row['createdAt']); return date("Y", $time) == date("Y", strtotime(date("Y-m-d"))); });
        return array_filter($arr, function ($row) { $time = strtotime($row['createdAt']); return date("F", $time) == date("F", strtotime(date("Y-m-d"))); });
    }

    private function getPrice($arr, $period) {
        $data = $this->filterByPeriodBought($arr, $period);

        $itemPriceModel = new ItemPriceModel();
        $price = 0;

        foreach ($data as $row){
            $priceRow = $itemPriceModel->where('idItem', $row['idItem'])->where('idShopChain', $row['idShop'])->first();
            if($priceRow == null)
                $priceRow = $itemPriceModel->where('idItem', $row['idItem'])->first();
            if($priceRow != null)
                $price += $priceRow['price'];
        }

        return $price;
    }

    private function getItems() {
        $user = $this->session->get('user');
        $listContainsModel = new ListContainsModel();
        return $listContainsModel->where('idUser', $user['idUser'])->join('item', 'item.idItem = listcontains.idItem')->findAll();
    }

    private function groupItems($items) {
        $nameCnt = [];
        foreach ($items as $item) {
            if(!isset($nameCnt[$item['name']]))
                $nameCnt[$item['name']] = 1;
            else
                $nameCnt[$item['name']]++;
        }
        arsort($nameCnt);
        return $nameCnt;
    }

    public function index()
    {
        $user = $this->session->get('user');
        $listContainsModel = new ListContainsModel();
        $shoppingListModel = new ShoppingListModel();

        // idItem idShop bought
        $prices = $listContainsModel->where('idUser', $user['idUser'])
            ->join('shoppinglist', 'shoppinglist.idShoppingList = listcontains.idShoppingList')->findAll();
        $shoppingLists = $shoppingListModel->join('ingroup', 'ingroup.idGroup = shoppinglist.idGroup')->where('idUser', $user['idUser'])->findAll();
        $items = $this->getItems();

        $itemsMonth = $this->filterByPeriodBought($items, "month");
        $itemsYear = $this->filterByPeriodBought($items, "year");

        $nameCntMonth = $this->groupItems($itemsMonth);
        $nameCntYear = $this->groupItems($itemsYear);

        $priceToday = $this->getPrice($prices, "today");
        $priceMonth = $this->getPrice($prices, "month");
        $priceYear = $this->getPrice($prices, "year");

        $noToday = count($this->filterByPeriodCreatedAt($shoppingLists, "today"));
        $noMonth = count($this->filterByPeriodCreatedAt($shoppingLists, "month"));
        $noYear = count($this->filterByPeriodCreatedAt($shoppingLists, "year"));

        echo view('common/header');
        echo view('profile', ['user' => $user, 'prices' => [$priceToday, $priceMonth, $priceYear],
            'noLists' => [$noToday, $noMonth, $noYear], 'items' => ['month' => $nameCntMonth, 'year' => $nameCntYear]]);
        echo view('common/footer');
    }
}
