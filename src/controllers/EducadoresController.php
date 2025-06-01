<?php

class EducadoresController
{
    public function show (){
    
        $data = [
            'title' => 'Educadores',
            'description' => 'Educadores - Laboratório de Transformação Digital',
        ];

        echo (new RenderTwig())->render('educadores', $data);
    }
}