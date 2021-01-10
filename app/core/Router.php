<?php

namespace app\core;

/**
 * Clase controladora que devuelve una vista
 * 
 */
class Router
{
    function __construct($POST, $GET)
    {
        if($_POST && $_POST['password'] === $_ENV['PASSWORD']) {
            $this->view($_GET['view']);
        } else {
            $this->view('auth');
        }
    }

    public function view($path)
    {
        require(dirname(__DIR__) . '/views/' . $path . '.phtml');
    }
}
