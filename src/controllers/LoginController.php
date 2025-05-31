<?php

class LoginController{
    public function show(){
        if(isset($_SESSION['user'])){
            header('Location: '.ROOT_PATH.'/');
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
            // Replace the following values with appropriate ones as required by Usuario's constructor
            $user = new Usuario($email, $password, null, null, null);
            // If setEmail and setSenha are still needed, keep them; otherwise, remove these lines
            // $user->setEmail($email);
            // $user->setSenha($password);
            if($user->login()){
                header('Location: '.ROOT_PATH.'/');
                exit();
            }else{
                header('Location: '.ROOT_PATH.'/login?error=Usuário ou senha inválidos');
                exit();
            }
        }else{
            header('Location: '.ROOT_PATH.'/login?error=Preencha todos os campos');
            exit();
        }
    }
    public function logout(){
        session_destroy();
        header('Location: '.ROOT_PATH.'/');
        exit();
    }
}