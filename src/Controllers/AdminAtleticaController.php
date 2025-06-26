<?php

namespace App\Controllers;

use App\Utils\Flash;
use App\Utils\View;
use App\Repositories\AtleticaRepository;
use App\Models\AtleticaMembro;
use App\HTTP\Response;
use App\HTTP\Request;
use App\Database\Pagination;
use App\Services\ImageUploader;

class AdminAtleticaController
{
    private $repository;
    private $view;

    public function __construct()
    {
        // Adicionar verificação de admin aqui se necessário
        // if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
        //     header('Location: ' . BASE_URL . '/login');
        //     exit;
        // }
        $this->repository = new AtleticaRepository();
        $this->view = new View();
    }

    public function index(Request $request)
    {
        $queryParams = $request->getQueryParams();
        $currentPage = $queryParams['page'] ?? 1;
        
        $total = $this->repository->count();
        $pagination = new Pagination($total, $currentPage, 10);
        
        $membros = $this->repository->findAll('id DESC', $pagination->getLimit());

        return $this->view->render('admin/atletica/index', [
            'membros' => $membros,
            'pagination' => $pagination->getPages(),
            'flash' => Flash::get('message')
        ]);
    }

    public function create()
    {
        return $this->view->render('admin/atletica/form', [
            'title' => 'Adicionar Novo Membro',
            'action' => BASE_URL . '/admin/atletica/create',
            'membro' => new AtleticaMembro(),
            'button_label' => 'Cadastrar Membro'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->getBody();
        $membro = new AtleticaMembro();
        $membro->setNome($data['nome']);
        $membro->setCargo($data['cargo']);
        $membro->setInstagramUrl($data['instagram_url']);

        $imagePath = ImageUploader::upload($data, $_FILES, 'atletica');
        if ($imagePath) {
            $membro->setFoto($imagePath);
        }

        $this->repository->save($membro);
        Flash::set('message', 'Membro adicionado com sucesso!');

        $response = new Response(302, '');
        $response->addHeader('Location', BASE_URL . '/admin/atletica');
        return $response;
    }

    public function edit(Request $request, array $params)
    {
        $id = (int)$params['id'];
        $membro = $this->repository->findById($id);

        if (!$membro) {
            Flash::set('message', 'Membro não encontrado.');
            $response = new Response(302, '');
            $response->addHeader('Location', BASE_URL . '/admin/atletica');
            return $response;
        }
        
        return $this->view->render('admin/atletica/form', [
            'title' => 'Editar Membro',
            'action' => BASE_URL . '/admin/atletica/edit/' . $id,
            'membro' => $membro,
            'button_label' => 'Salvar Alterações'
        ]);
    }

    public function update(Request $request, array $params)
    {
        $id = (int)$params['id'];
        $data = $request->getBody();
        $membro = $this->repository->findById($id);

        if (!$membro) {
            Flash::set('message', 'Membro não encontrado.');
            $response = new Response(302, '');
            $response->addHeader('Location', BASE_URL . '/admin/atletica');
            return $response;
        }

        $membro->setNome($data['nome']);
        $membro->setCargo($data['cargo']);
        $membro->setInstagramUrl($data['instagram_url']);

        $oldImage = $membro->getFoto();
        $newImage = ImageUploader::upload($data, $_FILES, 'atletica', $oldImage);
        
        if ($newImage) {
            $membro->setFoto($newImage);
        } elseif (isset($data['remove_current_image']) && $data['remove_current_image'] == '1') {
            // Se "remover imagem" for marcado e nenhuma nova imagem for enviada
            ImageUploader::delete($oldImage);
            $membro->setFoto(null); // Limpa o caminho da foto no banco de dados
        }

        $this->repository->save($membro);
        Flash::set('message', 'Membro atualizado com sucesso!');
        
        $response = new Response(302, '');
        $response->addHeader('Location', BASE_URL . '/admin/atletica');
        return $response;
    }

    public function destroy(Request $request, array $params)
    {
        $id = (int)$params['id'];
        $membro = $this->repository->findById($id);

        if ($membro) {
            ImageUploader::delete($membro->getFoto());
            $this->repository->delete($id);
            Flash::set('message', 'Membro deletado com sucesso!');
        } else {
            Flash::set('message', 'Membro não encontrado.');
        }

        $response = new Response(302, '');
        $response->addHeader('Location', BASE_URL . '/admin/atletica');
        return $response;
    }
}
