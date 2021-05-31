<?php

namespace App\Controllers;

use App\Models\UserModel;


class HomePage extends BaseController {

    public function render()
    {
        echo view('common/header', ['home' => '']);
        echo view('home', []);
        echo view('common/footer', []);
    }

    public function index()
    {
        $this->render();
    }

    public function lists()
    {
        $this->render();
    }

    public function groups()
    {
        $this->render();
    }

    public function profile()
    {
        $this->render();
    }

    public function notifications()
    {
        $this->render();
    }
}