<?php

namespace App\Controllers;

use App\Utils\Flash;
use App\Utils\View;
use App\Repositories\NoticiaRepository;
use App\Repositories\CategoriaRepository;
use App\Models\Noticia;
use App\Utils\StringUtils;


use App\HTTP\Response; // Certifique-se de que esta linha está presente

use App\HTTP\Request;

use App\Services\ImageUploader;


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

        return $content;
    }

    /**
     * Salva uma nova notícia no banco de dados.
     */
    public function store(Request $request)
    {
        $data = $request->getBody();

        $userId = $_SESSION['user']['id'] ?? 1;

        // processo de cadastro de noticia
        $noticia = new Noticia();
        $noticia->setTitulo($data['titulo']);
        $noticia->setConteudo($data['conteudo']);
        $noticia->setIdCategoria((int)$data['categoria_id']);
        $noticia->setSlug(StringUtils::slugify($data['titulo']));
        $noticia->setIdUsuario($userId);
        $imagePath = ImageUploader::upload($data, $_FILES, 'noticias', null, $noticia->getSlug());
        if ($imagePath) {
            $noticia->setImagem(ROOT_PATH . '/public/' . $imagePath);
        }

        // salva no banco de dados
        $this->noticiaRepository->save($noticia);

        // redireciona para a página de notícias
        Flash::set('message', 'Notícia cadastrada com sucesso!');
        // Substituindo header('Location: ...'); exit;
        $response = new Response(302, '');
        $response->addHeader('Location', BASE_URL . '/admin/noticias');
        return $response;
    }


    public function edit($request, $params)
    {
        $id = $params['id'];
        $noticia = $this->noticiaRepository->findById($id);

        if (!$noticia) {
            Flash::set('message', 'Notícia não encontrada.');
            // Substituindo header('Location: ...'); exit;
            $response = new Response(302, '');
            $response->addHeader('Location', BASE_URL . '/admin/noticias');
            return $response;
        }

        $categorias = $this->categoriaRepository->findAll();
        $content = $this->view->render('admin/noticias/form', [
            'title' => 'Editar Notícia',
            'action' => BASE_URL . '/admin/noticias/edit/' . $id,
            'noticia' => $noticia,
            'categorias' => $categorias,
            'button_label' => 'Salvar Alterações'
        ]);

        return  $content;
    }

    public function update(Request $request, $params)
    {
        $data = $request->getBody();

        $id = $params['id'];
        $noticia = $this->noticiaRepository->findById($id);

        if (!$noticia) {
            Flash::set('message', 'Notícia não encontrada.');
            // Substituindo header('Location: ...'); exit;
            $response = new Response(302, '');
            $response->addHeader('Location', BASE_URL . '/admin/noticias');
            return $response;
        }

        $newImagePath = ImageUploader::upload($data, $_FILES, 'noticias', $noticia->getImagem(), $noticia->getSlug());
        if ($newImagePath) {
            $noticia->setImagem( $newImagePath);
        }
        $noticia->setTitulo($data['titulo']);
        $noticia->setConteudo($data['conteudo']);
        $noticia->setIdCategoria((int)$data['categoria_id']);
        $noticia->setSlug(StringUtils::slugify($data['titulo']));


        $this->noticiaRepository->save($noticia);

        Flash::set('message', 'Notícia atualizada com sucesso!');
        // Substituindo header('Location: ...'); exit;
        $response = new Response(302, '');
        $response->addHeader('Location', BASE_URL . '/admin/noticias');
        return $response;
    }

    /**
     * Exibe a página de confirmação para deletar uma notícia.
     * @param int $id
     */
    public function delete($request, $params)
    {
        $noticia = $this->noticiaRepository->findById($params['id']);
        if (!$noticia) {
            Flash::set('message', 'Notícia não encontrada.');
            // Substituindo header('Location: ...'); exit;
            $response = new Response(302, '');
            $response->addHeader('Location', BASE_URL . '/admin/noticias');
            return $response;
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
        // Substituindo header('Location: ...'); exit;
        $response = new Response(302, '');
        $response->addHeader('Location', BASE_URL . '/admin/noticias');
        return $response;
    }
}