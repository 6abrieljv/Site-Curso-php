<?php


class NoticiasController{


    public function index()
    { 
        $noticiasRepository = new NoticiaRepository();

        $noticias = $noticiasRepository->findAll();
        $data = [
            'noticias' => $noticias
        ];
        echo "<pre>";
        var_dump($data['noticias'][0]);
        echo "</pre>";
        return (new RenderTwig())->render('noticias', $data);
    }
}