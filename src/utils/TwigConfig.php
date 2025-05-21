<?php


class TwigConfig {
    private $twig;


    public function __construct(){
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__."/../views");
        $this->twig = new \Twig\Environment($loader, [
            'cache' => false,
            'debug' => true,
        ]);

        // load assets
        $this->addGlobal('assets_global',"/public/assets");

        $this->twig->addGlobal('assets', [
            'css' => '/public/assets/css',
            'js' => '/public/assets/js',
            'img' => '/Site-Curso-php/public/assets/img',
        ]);


        
    }
    public function render($template, $data = []) {
        return $this->twig->render($template, $data);
    }

    public function addFunction($name, $callable) {
        $this->twig->addFunction(new \Twig\TwigFunction($name, $callable));
    }

    public function addFilter($name, $callable) {
        $this->twig->addFilter(new \Twig\TwigFilter($name, $callable));
    }

    public function addGlobal($name, $value) {
        $this->twig->addGlobal($name, $value);
    }
}