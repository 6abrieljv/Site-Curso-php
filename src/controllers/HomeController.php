<?php

class HomeController
{
    public function index()
    {
        return (new RenderTwig())->render('home', [
            'title' => 'Home',
            
        ]);
    }
}
