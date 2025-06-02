<?php


class NoticiasController{


    public function show()
    {
        
        
        return (new RenderTwig())->render('noticias', []);
    }
}