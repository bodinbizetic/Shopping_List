<?php
/**
 * Autor - Olga Maslarevic 0007/2018
 */
namespace App\Controllers;

use App\Models\InGroupModel;
use App\Models\ListContainsModel;
use App\Models\UserModel;

/**
 * Class Profile - Klasa za upravljanje nalogom korisnika
 *
 * @package App\Controllers
 * @version 1.0
 */
class Profile extends BaseController
{
    /**
     * Pomocna funkcija - dohvata potrosnju korisnika na godisnjem nivou
     *
     * @param $idUser - id korisnika za koga se dohvataju informacije o potrosnji
     *
     * @return array - niz parova oblika { Year, Spending }
     */
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
                ->groupBy('month')
                ->findAll();
    }

    /**
     * Pomocna funkcija - dohvata broj listi koje je korisnik napravio za svaki mesec tekuce godine
     *
     * @param $idUser - id korisnika za koga se dohvata broj listi
     *
     * @return array - niz parova oblika { Month, Count }
     */
    private function getNoListsByMonth($idUser)
    {
        $inGroupModel = new InGroupModel();
        $toReturn =  $inGroupModel->where('idUser', $idUser)
            ->join('shoppinglist', 'shoppinglist.idGroup = ingroup.idGroup')
            ->select('MONTH(createdAt) as month, COUNT(*) as count')
            ->groupBy('month')
            ->findAll();
        return array_filter($toReturn, function($elem) {
            return $elem['month'] != null;
        });
    }

    /**
     * Pomocna funkcija - dohvata najtrazenije proizvode datog korisnika za tekucu godinu
     *
     * @param $limit - limit u broju proizvoda
     * @param $idUser - id korisnika za koga se vrsi pretraga najtrazenijih proizvoda
     *
     * @return array - niz proizvoda sortiranih opadajuce po potraznji
     */
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

    /**
     * Pomocna funkcija - dohvata najtrazenije proizvode datog korisnika za tekuci mesec
     *
     * @param $limit - limit u broju proizvoda
     * @param $idUser - id korisnika za koga se vrsi pretraga najtrazenijih proizvoda
     *
     * @return array - niz proizvoda sortiranih opadajuce po potraznji
     */
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

    /**
     * Pomocna funkcija - formatira podatke o potrosni u oblik pogodan za prikaz na Chart diagramu
     *
     * @param $monthSpendings - niz parova oblika {Month, Spending} koje je potrebno formatirati
     * @return false|string - formatirani podaci pogodni za prikaz
     */
    private function displayAsChartSpending($monthSpendings)
    {
        $data = [];
        $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        foreach ($monthSpendings as $monthSpending) {
            $data['label'][] = $months[$monthSpending['month'] - 1];
            $data['data'][] = $monthSpending['spending'];

        }
        return json_encode($data);
    }

    /**
     * Pomocna funkcija - formatira  odatke o broju lista u oblik pogodan za prikaz na Chart diagramu
     *
     * @param $monthNoLists - niz parova oblika {Month, Number of Lists} koje je potrebno formatirati
     * @return false|string - formatirani podaci pogodni za prikaz
     */
    private function displayAsChartNoLists($monthNoLists)
    {
        $noLists = [];
        $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        foreach ($monthNoLists as $monthNoList) {
            $noLists['label'][] = $months[$monthNoList['month'] - 1];
            $noLists['data'][] = $monthNoList['count'];

        }
        return json_encode($noLists);
    }

    /**
     * Pomocna funkcija - formatira podatke o najtrazenijim proizvodima u oblik pogodan za prikaz na Pie diagramu
     *
     * @param $popularItems - niz parova oblika {Item Name, Popular} koje je potrebno formatirati
     * @return false|string - formatirani podaci pogodni za prikaz
     */
    private function displayAsPie($popularItems)
    {
        $arrOfArr = [];
        foreach ($popularItems as $popularItem) {
            array_push($arrOfArr, [$popularItem['name'], (int)$popularItem['count']]);
        }
        return json_encode($arrOfArr);
    }

    /**
     * Proverava da li su podaci validni i azurira korisnikov nalog na sistemu
     *
     * @param $oldUser - korisnik ciji se podaci azuriraju
     * @param $newUser - korisnik sa azuriranim podacima
     * @return string|null
     * @throws \ReflectionException
     */
    private function updateUser($oldUser, $newUser) {

        $this->validation->reset();
        $this->validation->setRuleGroup('edit');
        if(!$this->validation->run($newUser)) {
            $err_str = "";
            foreach ($this->validation->getErrors() as $key => $value) {
                $err_str = $err_str. "<br>". $value;
            }
            return $err_str;
        }

        $userModel = new UserModel();

        $userWithSameUsername = $userModel->findByUsername($newUser['username']);
        if(isset($userWithSameUsername) && $userWithSameUsername['idUser'] != $oldUser['idUser'])
            return "Sorry. That username has already been taken. Please choose another.";

        $userWithSameEmail = $userModel->findByEmail($newUser['email']);
        if(isset($userWithSameEmail) && $userWithSameEmail['idUser'] != $oldUser['idUser'])
            return "Sorry. That email has already been taken. Please choose another.";

        $userModel->update($oldUser['idUser'], $newUser);
        return null;
    }

    /**
     * Dohvata izmenjene podatke i azurira korisnikov direktorijum sa izmenjenim fajlovima (brise one koje vise ne koristi u upload novih)
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     * @throws \ReflectionException
     */
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
            'password' => $this->request->getPost('password'),
            'idUser'   => $user['idUser']
        ];

        if($data['phone'] == "")
            $data['phone'] = null;

        if($this->request->getFile('image')->getName() != "") {
            $time_unique = strtotime("now");
            $data['image'] = $time_unique. "/". $this->request->getFile('image')->getName();
        } else
            $data['image'] = $user['image'];

        $errors = $this->updateUser($user, $data);

        if(isset($errors))
            return redirect()->to(site_url('profile/index/'. $errors));

        if(isset($user['image']) && $data['image'] != $user['image']) {
            $dir_file = explode( '/', $user['image']);

            delete_files(ROOTPATH . 'public\uploads\\' . $dir_file[0], true);
            rmdir(ROOTPATH . 'public\uploads\\' . $dir_file[0]);
        }
        if(isset($data['image']) && $data['image'] != $user['image']) {

            $dir_file = explode( '/', $data['image']);
            $this->request->getFile('image')->move(ROOTPATH . 'public\uploads\\' . $dir_file[0], $this->request->getFile('image')->getName());
        }

        $this->session->set('user', $data);
        return redirect()->to(site_url('profile/index/'));
    }

    /**
     * Prikaz stranice sa informacijama o korisniku
     * Prikaz statistike korisnika u obliku Char i Pie diagrama
     *
     * @param null $errors - greske koje su se pojavile prilikom azuriranja profila
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function index($errors = null)
    {
        // auth guard
        if(!$this->session->has('user'))
            return redirect()->to('/login/index');
        $user = $this->session->get('user');

        $data = [];

        $monthSpending = $this->getSpendingByMonth($user['idUser']);
        $noListsByMonth = $this->getNoListsByMonth($user['idUser']);

        $popularItemsYear = $this->getPopularItemsYear(5, $user['idUser']);
        $popularItemsMonth= $this->getPopularItemsMonth(5, $user['idUser']);

        $data['chart_data_spending'] = $this->displayAsChartSpending($monthSpending);
        $data['chart_data_lists'] = $this->displayAsChartNoLists($noListsByMonth);
        $data['data_for_pie_year'] =  $this->displayAsPie($popularItemsYear);
        $data['data_for_pie_month'] = $this->displayAsPie($popularItemsMonth);
        $data['user'] = $user;
        $data['errors'] = $errors;

        echo view('common/header', [ 'profile' => '']);
        echo view('profile', $data);
        echo view('common/footer');
    }
}
