<?php

class LoginController{
    public function show(){
        if(isset($_SESSION['user'])){
            header('Location: '.ROOT_PATH.'/');
            exit();
        }else{
            return (new RenderTwig())->render('login', [
                'error' => isset($_GET['error']) ? $_GET['error'] : null,
                'success' => isset($_GET['success']) ? $_GET['success'] : null,
            ]);
        }
    }
    public function login(){
        
    }
    public function logout(){
        session_destroy();
        header('Location: '.ROOT_PATH.'/');
        exit();
    }
}