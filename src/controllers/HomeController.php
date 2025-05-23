<?php

class HomeController
{
    public function index()
    {
        echo (new RenderTwig())->render('home', [
            'title' => 'Home',
            
        ]);
    }
}
