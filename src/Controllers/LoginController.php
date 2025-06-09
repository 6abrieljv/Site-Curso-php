<?php
namespace App\Controllers;
use App\Utils\View;
use App\Repositories\UsuarioRepository;
use App\Utils\Flash;


class LoginController{
    private $usuarioRepository;

    public function __construct(){
        $this->usuarioRepository = new UsuarioRepository();
    }
    public function show(){
        if(isset($_SESSION['user'])){
            header('Location: '.ROOT_PATH.'/');
            exit();
        }else{
            return (new View())->render('login', [
                'error' => isset($_GET['error']) ? $_GET['error'] : null,
                'success' => isset($_GET['success']) ? $_GET['success'] : null,
            ]);
        }
    }
    public function login(){
        if(isset($_POST['email']) && isset($_POST['senha'])){
            $usuario = $this->usuarioRepository->findByEmail($_POST['email']);
            if($usuario && password_verify($_POST['password'], $usuario->getSenha())){
                $_SESSION['user'] = $usuario;
                header('Location: '.ROOT_PATH.'/');
                exit();
            }else{
                Flash::set('error', '');
                exit();
            }
        }else{
            header('Location: '.ROOT_PATH.'/login?error=Please fill in all fields');
            exit();
        }


        
    }
    public function logout(){
        session_destroy();
        header('Location: '.ROOT_PATH.'/');
        exit();
    }
}