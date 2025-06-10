<?php

namespace App\Controllers;

use App\Utils\Flash;
use App\Utils\View;
use App\Repositories\NoticiaRepository;
use App\Repositories\CategoriaRepository;
use App\Models\Noticia;
use App\Utils\StringUtils;

use App\HTTP\Response;
use App\HTTP\Request;

class AdminNoticiasController
{
    private $noticiaRepository;
    private $categoriaRepository;
    private $view;

    public function __construct()
    {
        $this->noticiaRepository = new NoticiaRepository();
        $this->categoriaRepository = new CategoriaRepository();
        $this->view = new View();
    }

    /**
     * Lista todas as notícias no painel de administração.
     */
    public function index()
    {
        $noticias = $this->noticiaRepository->findAll();
        $categorias = $this->categoriaRepository->findAll();
        
        $content = $this->view->render('admin/noticias/index', [
            'noticias' => $noticias,
            'flash' => Flash::get('message'),
            'categorias' =>  $categorias
        ]);

        return $content;
    }

    /**
     * Exibe o formulário para criar uma nova notícia.
     */
    public function create()
    {
        $categorias = $this->categoriaRepository->findAll();
        $content = $this->view->render('admin/noticias/form', [
            'title' => 'Cadastrar Nova Notícia',
            'action' => BASE_URL . '/admin/noticias/create',
            'noticia' => new Noticia(), // Notícia vazia para o formulário
            'categorias' => $categorias,
            'button_label' => 'Cadastrar'
        ]);

        return new Response(200, $content);
    }

    /**
     * Salva uma nova notícia no banco de dados.
     */
    public function store(Request $request)
    {
        $data = $request->getBody();

        $noticia = new Noticia();
        $noticia->setTitulo($data['titulo']);
        $noticia->setConteudo($data['conteudo']);
        $noticia->setIdCategoria((int)$data['categoria_id']);
        $noticia->setSlug(StringUtils::slugify($data['titulo']));

        // Simulação de usuário logado (substituir pela lógica de autenticação)
        $noticia->setIdUsuario(1);

        $this->noticiaRepository->save($noticia);

        Flash::set('message', 'Notícia cadastrada com sucesso!');
        header('Location: ' . BASE_URL . '/admin/noticias');
        exit;
    }

    /**
     * Exibe o formulário para editar uma notícia existente.
     * @param int $id
     */
    public function edit($id)
    {
        $noticia = $this->noticiaRepository->findById((int)$id);
        if (!$noticia) {
            Flash::set('message', 'Notícia não encontrada.');
            header('Location: ' . BASE_URL . '/admin/noticias');
            exit;
        }

        $categorias = $this->categoriaRepository->findAll();
        $content = $this->view->render('admin/noticias/form', [
            'title' => 'Editar Notícia',
            'action' => BASE_URL . '/admin/noticias/edit/' . $id,
            'noticia' => $noticia,
            'categorias' => $categorias,
            'button_label' => 'Salvar Alterações'
        ]);

        return new Response(200, $content);
    }

    /**
     * Atualiza uma notícia no banco de dados.
     * @param Request $request
     * @param int $id
     */
    public function update(Request $request, $id)
    {
        $data = $request->getBody();
        $noticia = $this->noticiaRepository->findById((int)$id);

        if (!$noticia) {
            Flash::set('message', 'Notícia não encontrada.');
            header('Location: ' . BASE_URL . '/admin/noticias');
            exit;
        }

        $noticia->setTitulo($data['titulo']);
        $noticia->setConteudo($data['conteudo']);
        $noticia->setIdCategoria((int)$data['categoria_id']);
        $noticia->setSlug(StringUtils::slugify($data['titulo']));

        $this->noticiaRepository->save($noticia);

        Flash::set('message', 'Notícia atualizada com sucesso!');
        header('Location: ' . BASE_URL . '/admin/noticias');
        exit;
    }

    /**
     * Exibe a página de confirmação para deletar uma notícia.
     * @param int $id
     */
    public function delete($request, $params)
    {
        // echo "<pre>";
        // var_dump($request, $params);
        // echo "</pre>";
        // exit;

        $noticia = $this->noticiaRepository->findById($params['id']);
        if (!$noticia) {
            Flash::set('message', 'Notícia não encontrada.');
            header('Location: ' . BASE_URL . '/admin/noticias');
            exit;
        }

        $content = $this->view->render('admin/noticias/delete', [
            'noticia' => $noticia
        ]);
        return $content;
    }


    public function destroy($request, $params)
    {
        $this->noticiaRepository->delete($params['id']);
        Flash::set('message', 'Notícia deletada com sucesso!');
        header('Location: ' . BASE_URL . '/admin/noticias');
        exit;
    }
}
