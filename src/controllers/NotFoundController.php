<?php

class NotFoundController{
    public function show(){
        echo(new RenderTwig())->render('404', [
            'title' => 'Página não encontrada',
            'description' => 'A página que você está procurando não existe.'] );
            
    }}