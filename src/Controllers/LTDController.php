<?php
namespace App\Controllers;
use App\Utils\View;
class LTDController
{
    

    public function index()
    {
        $data = [
            'title' => 'LTD',
            'description' => 'LTD - Liga de Treinamento e Desenvolvimento',
        ];

        return (new View())->render('ltd', $data);
    }
}