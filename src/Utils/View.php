<?php
namespace App\Utils;

use App\HTTP\Request;

class View
{
    private $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader(ROOT_PATH . '/src/Views');
        $this->twig = new \Twig\Environment($loader);
        $this->twig->addGlobal('base_url', BASE_URL);
        $this->twig->addGlobal('assets', 'public/assets');
        // Adicionar o favicon como uma variável global para fácil acesso nas views Twig
        $this->twig->addGlobal('favicon_path', BASE_URL . '/public/assets/img/logos/favicon pato site.png'); //
        $this->twig->addGlobal('links', [
            // Link 'Home' REMOVIDO daqui.
            'Notícias' => BASE_URL.'/noticias',
            'LTD' => BASE_URL.'/ltd',
            'Educadores' => BASE_URL.'/educadores',
            'Atlética' => BASE_URL.'/atletica',
            'Podpink'=> BASE_URL.'/podpink',
            'Perfil' => BASE_URL.'/perfil',
            'Sobre' => BASE_URL.'/sobre',
        ]);
        $this->twig->addGlobal('user', isset($_SESSION['user']) ? $_SESSION['user'] : null);
        
        $this->twig->addGlobal('app', ['request' => new Request()]);
    }

    public function render($template, $data = [])
    {
        return $this->twig->render("$template.html.twig", $data);
    }
}