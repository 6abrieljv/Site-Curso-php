<?php
namespace App\Controllers;
use App\Utils\View;

class PodPinkController
{
    public function index()
    {

        // Render the view with the fetched data
        return (new View())->render('podpink', [
            
        ]);
    }
}
