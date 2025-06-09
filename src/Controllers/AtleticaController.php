<?php
namespace App\Controllers;
use App\Utils\View;
class AtleticaController {
    public function index(){
        
    
        return (new View())->render('atletica');
    }
}