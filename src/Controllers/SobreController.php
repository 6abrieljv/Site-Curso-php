<?php
namespace App\Controllers;
use App\Utils\View;

class SobreController{
    public function  index()
    {

        return (new View())->render('sobre');
    }
}