<?php
/**
 * Autor - Olga Maslarevic 0007/2018
 */
namespace App\Controllers;

use App\Models\UserModel;

/**
 * Class HomePage - klasa na koju se 'obican' korisnik upucuje nakon uspesne prijave na sistem
 *
 * @package App\Controllers
 * @version 1.0
 */
class HomePage extends BaseController {


    /**
     * Prikazuje header sa navigacionim barom, footer i stranicu dobrodoslice korisniku sajta
     *
     *  @return void
     */
    public function render()
    {
        echo view('common/header', ['home' => '']);
        echo view('home', []);
        echo view('common/footer', []);
    }

    /**
     *  Poziva prikaz stranice dobrodoslice
     *
     * @return void
     */
    public function index()
    {
        $this->render();
    }

}