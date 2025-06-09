<?php
namespace App\Controllers;
use App\Utils\View;
class EducadoresController
{
    public function index (){
    
        $data = [
            'title' => 'Educadores',
            'description' => 'Educadores - Laboratório de Transformação Digital',
        ];

        return (new View())->render('educadores', $data);
    }
}