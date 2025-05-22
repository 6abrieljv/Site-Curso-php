<?php

class HomeController {
    public function index(){
        $twig = new TwigConfig();
        $data = [
            'title' => 'Home',
            'description' => 'Welcome to the home page',
            'content' => 'This is the home page content',
        ];
        echo $twig->render('home.html.twig', $data);
    }
}