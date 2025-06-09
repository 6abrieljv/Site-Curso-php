<?php

class Auth
{
    private $usuarioRepository;
    private $user;

    public function __construct()
    {
        $this->usuarioRepository = new UsuarioRepository();
        $this->user = null;
    }

    public function login($email, $password)
    {
        $user = $this->usuarioRepository->findByEmail($email);
        if ($user && password_verify($password, $user->getSenha())) {
            $_SESSION['user'] = $user;
            $this->user = $user;
            return true;
        }
        return false;
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