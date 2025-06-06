<?php

class Auth
{
    private $usuarioRepository;
    private $user;

    public function __construct()
    {
        $this->db = new UsuarioRepository();
        $this->user = null;
    }

    public function login($email, $password)
    {
        $this->usuarioRepository->
    }

    public function logout()
    {
        $_SESSION['user'] = null;
        session_destroy();
    }

    public function isLoggedIn()
    {
        return $this->user !== null;
    }

    public function getUser()
    {
        return $this->user;
    }
}