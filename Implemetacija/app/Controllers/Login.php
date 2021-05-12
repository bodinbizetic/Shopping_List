<?php

namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController {

    public function index(): string
    {
        return $this->renderLogin(null);
    }

    public function renderLogin($errors = null): string
    {
        return view('login', ['errors' => $errors]);
    }

    public function renderRegistration($errors = null): string
    {
        return view('registration', ['errors' => $errors]);
    }


    public function login(): string
    {
        if($this->session->has('user'))
            return $this->renderLogin(["You are already logged in"]);

        $userModel = new UserModel();
        $user = $userModel->findByUsername($this->request->getPost('login_username'));

        if($user == null)
            return $this->renderLogin(["User with given username does not exist!"]);

        if($user['password'] != $this->request->getPost('login_password'))
            return $this->renderLogin(["Password is incorrect!"]);

        $this->session->set('user', $user);
        return $this->renderLogin(["Successfully"]);
    }

    public function register(): string
    {
        if($this->request->getPost('register_password') != $this->request->getPost('register_cpassword')) {
            return $this->renderRegistration(["Confirm password again!"]);
        }

        $data = [
            'username' => $this->request->getPost('register_username'),
            'fullName' => $this->request->getPost('register_fullname'),
            'email'    => $this->request->getPost('register_email'),
            'phone'    => $this->request->getPost('register_phone'),
            'password' => $this->request->getPost('register_password'),
            'image'    => $this->request->getPost('image')
        ];

        $userModel = new UserModel();
        if(!$userModel->save($data))
            return $this->renderRegistration($userModel->errors());

        return $this->renderRegistration(['Successfully!']);
    }
}