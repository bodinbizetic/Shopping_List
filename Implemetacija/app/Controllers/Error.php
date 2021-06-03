<?php
/**
 * Authors - Andrej Gobeljic 0019/2018
 */

namespace App\Controllers;

/**
 * Class Error - klasa zaduzena za prikaz gresaka
 *
 * @package App\Controllers
 * @version 1.0
 */
class Error extends BaseController
{
    /**
     * Funkcija za prikaz greske
     *
     * @param $error - Tekst greske
     * @return void
     */
    static function show($error){
        echo view("common/header");
        echo view("error", ['error' => $error
        ]);
        echo view("common/footer");
        die();
    }
}