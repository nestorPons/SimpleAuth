<?php

namespace app\core;

/**
 * Clase controladora que devuelve una vista
 * 
 */
class Router
{
    private $pass, $path, $pass_saved, $auth;
    // Se declara la pagina de inicio de la aplicación
    const PATH_INI = 'auth'; 

    function __construct(?array $POST, ?array $GET, ?array $SESSION, ?array $ENV)
    {
        $this->pass = $POST['password'] ?? '';
        $this->pass_saved = $ENV['PASSWORD'] ?? '';
        $this->path = $GET['view'] ?? false;
        $this->auth = $SESSION['auth'] ?? false;
    }
    /**
     * Decide cual es la vista que hay que cargar
     */
    public function route(): void
    {
        // Comprobamo que se haya autentificado correctamente
        if($this->path == self::PATH_INI) {
            $this->exit();
        } else if ($this->auth) {
            $this->view();
        } else if ($this->pass != '' && $this->pass_saved != '' && $this->pass === $this->pass_saved) {
            // Comprobamos que se ha introducido la contraseña correcta
            $this->auth = true;
            $this->view();
        } else {
            $this->exit();
        }
    }
    /**
     * Carga la vista
     */
    public function view(): void
    {
        try {
            require(dirname(__DIR__) . '/views/' . $this->path . '.phtml');
        } catch (\Exception $e) {
            echo 'No se ha encontrado la ruta: ',  $e->getMessage(), "\n";
        }
    }

    /**
     * Sale a la pagina inicial y destruimos la session actual
     */
    public function exit(): void
    {
        $this->auth = false;
        $this->path = self::PATH_INI;
        
        $this->view();
        session_destroy();
    }

    function getAuth()
    {
        return $this->auth;
    }
}
