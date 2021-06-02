<?php
/**
 * Author - Bodin Bizetic 0058/2018
 */

namespace App\Filters;


use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;


/**
 * Class LogedInFilter - propusta samo ako je korisnik ulogovan na platformu
 * @package App\Filters
 */
class LogedInFilter implements FilterInterface
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
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // TODO: Implement after() method.
    }
}