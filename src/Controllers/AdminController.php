<?php
namespace App\Controllers;
use App\Repositories\UsuarioRepository;
use App\Repositories\NoticiaRepository;
use App\Repositories\CategoriaRepository;
use App\Utils\View;

class AdminController{
    public function index()
    {

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