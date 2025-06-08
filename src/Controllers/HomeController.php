<?php

namespace App\controllers;
use App\Utils\View;
class HomeController
{
    public function index()
    {
        return (new View())->render('home', [
            'title' => 'Home',
            
        ]);
    }
}
