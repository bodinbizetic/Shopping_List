<?php

namespace App\Controllers;

use App\Models\InGroupModel;
use App\Models\ListContainsModel;
use App\Models\UserModel;

class Profile extends BaseController
{
    // month spending (only current year and shop is not NULL)
    private function getSpendingByMonth($idUser)
    {
        $listContainsModel = new ListContainsModel();
        return $listContainsModel->where('idUser', $idUser)
                ->where('YEAR(bought)', date('Y'))
                ->join('shoppinglist', 'shoppinglist.idShoppingList = listcontains.idShoppingList')
                ->whereNotIn('idShop', ['NULL'])
                ->join('itemprice', 'itemprice.idItem = listcontains.idItem AND itemprice.idShopChain = shoppinglist.idShop')
                ->join('item', 'item.idItem = listcontains.idItem')
                ->select('MONTH(bought) AS month, SUM(itemprice.price * item.quantity) AS spending')
                ->groupBy('MONTH(bought)')
                ->findAll();
    }

    private function displayAsChartSpending($monthSpendings)
    {
        $data = [];
        $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        foreach ($monthSpendings as $monthSpending) {
            $data['label'][] = $months[$monthSpending['month'] - 1];
            $data['data'][] = $monthSpending['spending'];

        }
        $data['chart_data_spending'] = json_encode($data);
        return $data;
    }

    private function displayAsChartNoLists($monthNoLists)
    {
        $noLists = [];
        $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        foreach ($monthNoLists as $monthNoList) {
            $noLists['label'][] = $months[$monthNoList['month'] - 1];
            $noLists['data'][] = $monthNoList['count'];

        }
        $noLists['chart_data_lists'] = json_encode($noLists);
        return $noLists;
    }

    private function getPopularItemsYear($limit, $idUser)
    {
        $listContainsModel = new ListContainsModel();
        return $listContainsModel->where('idUser', $idUser)
            ->where('YEAR(bought)', date('Y'))
            ->join('item', 'item.idItem = listcontains.idItem')
            ->select('listcontains.idItem AS idItem, item.name AS name, COUNT(listcontains.idItem) AS count')
            ->groupBy('listcontains.idItem')
            ->orderBy('count', "DESC")
            ->findAll($limit);
    }

    private function displayAsPie($popularItems)
    {
        $arrOfArr = [];
        foreach ($popularItems as $popularItem) {
            array_push($arrOfArr, [$popularItem['name'], (int)$popularItem['count']]);
        }
        return $arrOfArr;
    }

    private function getPopularItemsMonth($limit, $idUser)
    {
        $listContainsModel = new ListContainsModel();
        return $listContainsModel->where('idUser', $idUser)
            ->where('MONTH(bought)', date('m'))
            ->join('item', 'item.idItem = listcontains.idItem')
            ->select('listcontains.idItem AS idItem, item.name AS name, COUNT(listcontains.idItem) AS count')
            ->groupBy('listcontains.idItem')
            ->orderBy('count', "DESC")
            ->findAll($limit);
    }


    private function getNoListsByMonth($idUser)
    {
        $inGroupModel = new InGroupModel();
        $toReturn =  $inGroupModel->where('idUser', $idUser)
            ->where('MONTH(createdAt)', date('m'))
            ->join('shoppinglist', 'shoppinglist.idGroup = ingroup.idGroup')
            ->select('MONTH(createdAt) as month, COUNT(*) as count')
            ->findAll();
        return array_filter($toReturn, function($elem) {
            return $elem['month'] != null;
        });
    }

    public function edit()
    {
        // auth guard
        if(!$this->session->has('user'))
            return redirect()->to('/login/index');
        $user = $this->session->get('user');

        $data = [
            'username' => $this->request->getPost('username'),
            'fullName' => $this->request->getPost('fullName'),
            'email'    => $this->request->getPost('email'),
            'phone'    => $this->request->getPost('phone'),
            'password' => $this->request->getPost('password')
        ];

        if($data['phone'] == "")
            $data['phone'] = null;

        $avatar = $this->request->getFile('image');
        if($avatar->getName() != "")
            $data['image'] = '/uploads/'. $data['username']. '/'. $avatar->getName();
        else
            $data['image'] = $user['image'];

        $userModel = new UserModel();

        if(!$userModel->update($user['idUser'], $data)) {
            $errors = $userModel->getValidationMessages();

            if((isset($errors['username']) && $data['username'] == $user['username']) || (isset($errors['email']) && $data['email'] == $user['email'])
                && !isset($errors['password']) && !isset($errors['fullName'])) {
                $userModel->skipValidation(true);
                $userModel->update($user['idUser'], $data);
            } else {
                $error_str = "";
                foreach ($errors as $error)
                    $error_str = $error_str. join("\N", array_values($error));
                return redirect()->to('profile/index/'. $error_str);
            }
        }

        if($user['image'] != null && $avatar->getName() != "") {
            delete_files(ROOTPATH . 'public\uploads\\'. $data['username'], true);
            rmdir(ROOTPATH . 'public\uploads\\'. $data['username']);
            $avatar->move(ROOTPATH . 'public\uploads\\'. $data['username']);
        }

        $this->session->set('user', $userModel->where('username', $data['username'])->first());
        return redirect()->to(site_url('profile/index/'));
    }

    public function index($errors = null)
    {
        // auth guard
        if(!$this->session->has('user'))
            return redirect()->to('/login/index');
        $user = $this->session->get('user');

        $monthSpending = $this->getSpendingByMonth($user['idUser']);
        $data = $this->displayAsChartSpending($monthSpending);

        $popularItemsYear = $this->getPopularItemsYear(5, $user['idUser']);
        $matrixYear = $this->displayAsPie($popularItemsYear);
        $popularItemsMonth= $this->getPopularItemsMonth(5, $user['idUser']);
        $matrixMonth = $this->displayAsPie($popularItemsMonth);

        $noListsByMonth = $this->getNoListsByMonth($user['idUser']);
        $noLists = $this->displayAsChartNoLists($noListsByMonth);

        $data['chart_data_lists'] = $noLists['chart_data_lists'];
        $data['data_for_pie_year'] = json_encode($matrixYear);
        $data['data_for_pie_month'] = json_encode($matrixMonth);
        $data['user'] = $user;
        $data['errors'] = $errors;

        echo view('common/header');
        echo view('profile', $data);
        echo view('common/footer');
    }
}
