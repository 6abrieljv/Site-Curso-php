<?php

class AtleticaController {
    public function show(){
        $twig = new TwigConfig();
    
        echo $twig->render('atletica.html.twig');
    }
}