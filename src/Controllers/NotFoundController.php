<?php

class NotFoundController{
    public function index(){
        return (new View())->render('404', [
            'title' => 'Página não encontrada',
            'description' => 'A página que você está procurando não existe.'] );
            
    }}