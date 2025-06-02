<?php

class EducadoresController
{
    public function show (){
    
        $data = [
            'title' => 'Educadores',
            'description' => 'Educadores - Laboratório de Transformação Digital',
        ];

        return (new RenderTwig())->render('educadores', $data);
    }
}