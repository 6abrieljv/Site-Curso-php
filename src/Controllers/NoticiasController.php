<?php


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