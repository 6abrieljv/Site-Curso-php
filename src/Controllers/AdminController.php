<?php
namespace App\Controllers;
use App\Repositories\UsuarioRepository;
use App\Repositories\NoticiaRepository;
use App\Repositories\CategoriaRepository;
use App\Utils\View;

class AdminController{
    public function index()
    {
        $usuarioRepository = new UsuarioRepository();
        $noticiaRepository = new NoticiaRepository();
        $categoriaRepository = new CategoriaRepository();

        $totalUsuarios = $usuarioRepository->count();
        $totalNoticias = $noticiaRepository->count();
        $totalCategorias = $categoriaRepository->count();

        // Renderizar a view com os usuários
        return (new View())->render('admin/index.html.twig', [
            'totalUsuarios' => $totalUsuarios,
            'totalNoticias' => $totalNoticias,
            'totalCategorias' => $totalCategorias,
        ]);
    }

    
}