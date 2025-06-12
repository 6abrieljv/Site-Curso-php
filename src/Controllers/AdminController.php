<?php
namespace App\Controllers;
use App\Repositories\UsuarioRepository;
use App\Repositories\NoticiaRepository;
use App\Repositories\CategoriaRepository;
use App\Utils\View;

class AdminController{

    // exibe dashboard do admin
    public function index()
    {

        // adicionar verificacao se o usuario é adm

        // if(!isset($_SESSION['user']) ||  !$_SESSION['user']['is_admin']){
        //     header('Location: ' . BASE_URL . '/login');
        //     exit;
        // }

        $status = [
            "totalUsuarios"=> (new UsuarioRepository())->cont(),
            "totalNoticias"=> (new NoticiaRepository())->cont(),
            "totalCategorias"=> (new CategoriaRepository())->cont()
        ];

        // Renderizar a view com os usuários
        return (new View())->render('admin/index', [
            "stats"=>$status
        ]);
    }

    
}