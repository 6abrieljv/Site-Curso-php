<?php

class AtleticaController {
    public function show(){
        $twig = new RenderTwig();
    
        echo $twig->render('atletica', [
            'title' => 'Atletica',
            
        ]);
    }
}