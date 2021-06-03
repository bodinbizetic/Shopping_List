<?php
/**
 * Autor - Olga Maslarevic 0007/2018
 */
namespace App\Controllers;

use App\Models\UserModel;
use http\Client\Curl\User;

/**
 * Konstante za tipove korisnika
 */
define("ADMIN", 0);
define("USER", 1);

/**
 * Class Login - Klasa za upravljanje prijavljivanjem, registracijom na sistem kao i odjavom sa sistema
 *
 * @package App\Controllers
 * @version 1.0
 */
class Login extends BaseController {

    /**
     * Prikaz forme za logovanje / registraciju ukoliko korisnik nije vec ulogovan
     * Prikaz Home stranice u suprotnom
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function index()
    {
        if($this->session->has('user')) {
            if($this->session->get('user')['type'] == ADMIN)
                return redirect()->to('/moderator/index');

            return redirect()->to('/homePage/index');
        }

        return $this->renderLogin(null);
    }

    /**
     * Prikaz forme za prijavu (login) na sistem
     *
     * @param null $errors - greske prilikom prijavljivanja na sistem (default null ako je sve uredu)
     * @return string
     */
    public function renderLogin($errors = null): string
    {
        return view('login/login', ['errors' => $errors]);
    }

    /**
     * Prikaz forme za registraciju na sistem
     *
     * @param null $errors - greske prilikom registracije na sistem (default null ako je sve uredu)
     * @return string
     */
    public function renderRegistration($errors = null): string
    {
        return view('login/registration', ['errors' => $errors]);
    }

    /**
     * Proverava da li u sistemu postoji korisnik sa unetim kredencijalima
     * Prikaz Home stranice korisnika pri uspesnoj prijavi
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
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

    /**
     * Odjavljuje korisnika sa sistema i zatvara njegovu sesiju
     *
     * @return string
     */
    public function logout()
    {
        $this->session->remove('user');
        return $this->renderLogin(null);
    }

    /**
     * Porverava validnost unetih podataka (da li zadovoljavaju ogranicejna sistema)
     * Kreira novog korisnika u sistemu i vrsi upload njegovih informacija na sistem
     *
     * @return string
     * @throws \ReflectionException
     */
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
            'type'      => USER
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