<?php

class LoginController{
    public function show(){
        if(isset($_SESSION['user'])){
            header('Location: '.ROOT_URL.'/');
            exit();
        }else{
            echo(new RenderTwig())->render('login', [
                'title' => 'Login',
                'description' => 'Entre com seu login e senha para acessar sua conta.',
                'error' => isset($_GET['error']) ? $_GET['error'] : null,
                'success' => isset($_GET['success']) ? $_GET['success'] : null,
            ]);
        }
    }
    public function login(){
        if(isset($_POST['email']) && isset($_POST['password'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user = new User();
            $user->setEmail($email);
            $user->setPassword($password);
            if($user->login()){
                header('Location: '.ROOT_URL.'/');
                exit();
            }else{
                header('Location: '.ROOT_URL.'/login?error=Usuário ou senha inválidos');
                exit();
            }
        }else{
            header('Location: '.ROOT_URL.'/login?error=Preencha todos os campos');
            exit();
        }
    }
    public function logout(){
        session_destroy();
        header('Location: '.ROOT_URL.'/');
        exit();
    }
}