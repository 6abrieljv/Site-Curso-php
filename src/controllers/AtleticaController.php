<?php

class AtleticaController {
    public function show(){
        
    
        echo (new RenderTwig())->render('atletica');
    }
}