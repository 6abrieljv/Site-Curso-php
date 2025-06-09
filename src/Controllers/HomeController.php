<?php

namespace App\Controllers;
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
