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
            'Home' => BASE_URL.'/',
            'LTD' => BASE_URL.'/ltd',
            'Podpink'=> BASE_URL.'/podpink',
            'Educadores' => BASE_URL.'/educadores',
            'Atletica' => BASE_URL.'/atletica',
            'Perfil' => BASE_URL.'/perfil',
        ]);
        $this->twig->addGlobal('user', [
            'name' => 'John Doe',
            'email' => 'jhon@gmail.com'] );
        
    }

    public function render($template, $data = [])
    {
        return $this->twig->render("$template.html.twig", $data);
    }
}