<?php
namespace App\Controllers;
use App\Utils\View;
use App\Repositories\NoticiaRepository;



class NoticiasController{


    public function index()
    { 
        $noticiasRepository = new NoticiaRepository();

        $noticias = $noticiasRepository->findAll();
        $data = [
            'noticias' => $noticias
        ];
        $noticias = $noticiasRepository->findAll();
        return (new View())->render('noticias', $data);
    }
}