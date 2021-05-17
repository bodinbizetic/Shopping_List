<?php

namespace App\Controllers;


class Profile extends BaseController
{
    public function index()
    {
        $user = $this->session->get('user');

        echo view('common/header');
        echo view('profile', ['user' => $user]);
        echo view('common/footer');
    }
}
