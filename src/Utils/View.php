<?php
namespace App\Utils;

class View
{
    private $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader(ROOT_PATH . '/src/Views');
        $this->twig = new \Twig\Environment($loader);
        $this->twig->addGlobal('base_url', BASE_URL);
        $this->twig->addGlobal('public', BASE_URL . '/public/');
        $this->twig->addGlobal('assets', 'public/assets');
        $this->twig->addGlobal('links', [
            'LTD' => BASE_URL.'/ltd',
            'Notícias' => BASE_URL.'/noticias',
            'Perfil' => BASE_URL.'/perfil',
            'Sobre' => BASE_URL.'/sobre',
            'Podpink'=> BASE_URL.'/podpink',
            'Educadores' => BASE_URL.'/educadores',
            'Atletica' => BASE_URL.'/atletica',

        ]);
        $this->twig->addGlobal('user', isset($_SESSION['user']) ? $_SESSION['user'] : null);
        
    }

    public function render($template, $data = [])
    {
        return $this->twig->render("$template.html.twig", $data);
    }
}