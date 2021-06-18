<?php
/**
 * Authors - Andrej Gobeljic 0019/2018
 */

namespace App\Filters;


use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;


/**
 * Class ModeratorFilter - propusta samo moderatore
 * @package App\Filters
 */
class ModeratorFilter implements FilterInterface
{
    /**
     * Poziva se pre metoda i odredjuje da li je korisnik ulogovan
     *
     * @param RequestInterface $request - objekat zahteva
     * @param null $arguments
     * @return \CodeIgniter\HTTP\RedirectResponse|mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->get('user') == null) {
            return redirect()->to('/login/index');
        }
        if(session()->get('user')['type'] == '1'){
            return redirect()->to('/homePage/index');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // TODO: Implement after() method.
    }
}