<?php


namespace App\Controllers;


class Error extends BaseController
{
    static function show($error){
        echo view("common/header");
        echo view("error", ['error' => $error
        ]);
        echo view("common/footer");
        die();
    }
}