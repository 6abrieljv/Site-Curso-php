<?php
class RenderView
{
    public function loadView($view, $args = [])
    {
        extract($args);
        $loader = new \Twig\Loader\FilesystemLoader([__DIR__ . '/../views']);
        $twig = new \Twig\Environment($loader);

        echo $twig->render('home.html.twig');
    }
}
