<?php

namespace App\Controllers;

use App\Utils\View;
use App\Repositories\UsuarioRepository;
use App\Utils\Flash;


class AuthController
{
    private $usuarioRepository;

    public function __construct()
    {
        $this->usuarioRepository = new UsuarioRepository();
        
    }

    public function index(){
        return (new View())->render("login");
    }

    
}
