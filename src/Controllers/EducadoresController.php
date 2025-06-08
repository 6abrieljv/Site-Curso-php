<?php

class EducadoresController
{
    public function show (){
    
        $data = [
            'title' => 'Educadores',
            'description' => 'Educadores - Laboratório de Transformação Digital',
        ];

        return (new View())->render('educadores', $data);
    }
}