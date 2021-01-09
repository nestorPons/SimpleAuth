<?php

namespace app\core;

/**
 * Clase controladora que devuelve una vista
 * 
 */
class Router
{
    function __construct()
    {

    }

    public function view($path)
    {
        require(dirname(__DIR__) . '/views/' . $path . '.phtml');
    }
}
