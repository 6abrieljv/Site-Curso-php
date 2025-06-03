<?php

class AtleticaController {
    public function show(){
        
    
        return (new RenderTwig())->render('atletica');
    }
}