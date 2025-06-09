<?php
namespace App\Controllers;
use App\Utils\View;
use App\Repositories\NoticiaRepository;



class NoticiasController{


    public function index($request=null)
    { 
        $noticiasRepository = new NoticiaRepository();


        $noticias = $noticiasRepository->findAll();
        $data = [
            'noticias' => $noticias
        ];
        $noticias = $noticiasRepository->findAll();
        return (new View())->render('noticias', $data);
    }
    public function show($slug)
    {
        $noticiasRepository = new NoticiaRepository();
        $noticia = $noticiasRepository->findBySlug($slug);
        
        if (!$noticia) {
            return (new View())->render('404');
        }

        $data = [
            'noticia' => $noticia
        ];
        
        return (new View())->render('noticia', $data);
    }
}