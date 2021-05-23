<?php

namespace App\Controllers;

use App\Models\UserModel;

define("ADMIN", 0);

class Login extends BaseController {

    public function index()
    {
        if($this->session->has('user')) {
            if($this->session->get('user')['type'] == ADMIN)
                return redirect()->to('/moderator/index');
            return redirect()->to('/homePage/index');
        }

        return $this->renderLogin(null);
    }

    public function renderLogin($errors = null): string
    {
        return view('login/login', ['errors' => $errors]);
    }

    public function renderRegistration($errors = null): string
    {
        return view('login/registration', ['errors' => $errors]);
    }


    public function login()
    {
        $userModel = new UserModel();
        $user = $userModel->findByUsername($this->request->getPost('login_username'));

        if($user == null)
            return $this->renderLogin(["User with given username does not exist!"]);

        if($user['password'] != $this->request->getPost('login_password'))
            return $this->renderLogin(["Password is incorrect!"]);

        $this->session->set('user', $user);
        if($user['type'] == ADMIN)
            return redirect()->to('/moderator/index');

        return redirect()->to('/homePage/index');
    }

    public function logout()
    {
        $this->session->remove('user');
        return $this->renderLogin(null);
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
            'password' => $this->request->getPost('register_password')
        ];

        if($data['phone'] == "")
            $data['phone'] = null;

        $this->validation->reset();
        $this->validation->setRuleGroup('registration');
        if(!$this->validation->run($data))
            return $this->renderRegistration($this->validation->getErrors());

        if($this->request->getFile('image')->getName() != "") {
            $time_unique = strtotime("now");
            $this->request->getFile('image')->move(ROOTPATH . 'public\uploads\\' . $time_unique, $this->request->getFile('image')->getName());
            $data['image'] = $time_unique. "/". $this->request->getFile('image')->getName();
        } else
            $data['image'] = null;

        (new UserModel())->save($data);

        return $this->renderRegistration(['Successfully!']);
    }
}