<?php


class NoticiasController{


    public function index()
    { 
        $noticiasRepository = new NoticiaRepository();

        $noticias = $noticiasRepository->findAll();
        $data = [
            'noticias' => $noticias
        ];
        return (new RenderTwig())->render('noticias', $data);
    }
}