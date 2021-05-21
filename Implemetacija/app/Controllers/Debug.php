<?php
namespace App\Controllers;

require __DIR__. '/../../vendor/autoload.php';



class Debug extends BaseController
{
    private $debug;


    public function index()
    {
        $debug = new \bdk\Debug(array(
        'collect' => true,
        'output' => true,
        ));
        $debug->log('hello world');

    }
}
