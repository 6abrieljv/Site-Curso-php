<?php


class RenderTwig
{
    private $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader(ROOT_PATH . '/src/views');
        $this->twig = new \Twig\Environment($loader);
        $this->twig->addGlobal('base_url', BASE_URL);
        $this->twig->addGlobal('assets', 'public/assets/');
        $this->twig->addGlobal('links', [
            'Home' => '/',
            'LTD' => '/ltd',
            'Educadores' => '/educadores',
            'Atletica' => '/atletica',
            'Perfil' => '/perfil',
        ]);
        $this->twig->addGlobal('user', [
            'name' => 'John Doe',
            'email' => 'jhon@gmail.com'] );
        
    }

    public function render($template, $data)
    {
        return $this->twig->render("$template.html.twig", $data);
    }
}