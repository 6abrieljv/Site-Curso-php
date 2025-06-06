<?php
namespace App\Controllers;

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
        return (new RenderTwig())->render('admin/index.html.twig', [
            'totalUsuarios' => $totalUsuarios,
            'totalNoticias' => $totalNoticias,
            'totalCategorias' => $totalCategorias,
        ]);
    }

    
}