<?php


class RenderTwig
{
    private $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader(ROOT_PATH . '/src/views');
        $this->twig = new \Twig\Environment($loader);
        $this->twig->addGlobal('base_url', ROOT_URL);
        $this->twig->addGlobal('assets', 'public/assets/');
        $this->twig->addGlobal('links', [
            'Home' => ROOT_URL.'/',
            'LTD' => ROOT_URL.'/ltd',
            'Educadores' => ROOT_URL.'/educadores',
            'Atletica' => ROOT_URL.'/atletica',
            'Perfil' => ROOT_URL.'/perfil',
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