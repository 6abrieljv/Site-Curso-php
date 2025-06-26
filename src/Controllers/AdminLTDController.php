<?php

namespace App\Controllers;

use App\HTTP\Request;
use App\Models\LTDProjeto;
use App\Repositories\LTDProjetoRepository;
use App\Repositories\TecnologiaRepository;
use App\Repositories\UsuarioRepository;
use App\Services\ImageUploader;
use App\Utils\Flash;
use App\Utils\View;

class AdminLTDController
{
    private $ltdProjetoRepository;
    private $usuarioRepository;
    private $tecnologiaRepository;
    private $view;

    public function __construct()
    {
        // // Garanta que apenas administradores acessem esta área
        // if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
        //     header('Location: ' . BASE_URL . '/login');
        //     exit;
        // }

        $this->ltdProjetoRepository = new LTDProjetoRepository();
        $this->usuarioRepository = new UsuarioRepository();
        $this->tecnologiaRepository = new TecnologiaRepository();
        $this->view = new View();
    }

    /**
     * Lista todos os projetos da LTD.
     */
    public function index($request, $params = [])
    {
        $projetos = $this->ltdProjetoRepository->findAll();

        return $this->view->render('admin/ltd/index', [
            'title' => 'Gerenciar Projetos LTD',
            'projetos' => $projetos,
            'flash' => Flash::get('message')
        ]);
    }

    /**
     * Exibe o formulário para criar um novo projeto.
     */
    public function create()
    {
        $todosUsuarios = $this->usuarioRepository->findAll(); // Você precisará criar este método no UsuarioRepository
        $todasTecnologias = $this->tecnologiaRepository->findAll(); // Você precisará criar este método no TecnologiaRepository

        return $this->view->render('admin/ltd/form', [
            'title' => 'Cadastrar Novo Projeto LTD',
            'action' => BASE_URL . '/admin/ltd/create',
            'projeto' => new LTDProjeto(),
            'todos_usuarios' => $todosUsuarios,
            'todas_tecnologias' => $todasTecnologias,
            'projeto_participantes_ids' => [], // Nenhum participante selecionado ainda
            'projeto_tecnologias_ids' => [],   // Nenhuma tecnologia selecionada ainda
            'button_label' => 'Cadastrar Projeto'
        ]);
    }

    /**
     * Salva um novo projeto no banco de dados.
     */
    public function store(Request $request)
    {
        $data = $request->getBody();

        $projeto = new LTDProjeto();
        $projeto->setNome($data['nome']);
        $projeto->setDescricao($data['descricao']);
        $projeto->setStatus($data['status']);
        $projeto->setPeriodo($data['periodo']);
        $projeto->setGithub($data['github_url']);

        // Upload da Imagem
        $imagePath = ImageUploader::upload($data, $_FILES, 'ltd_projetos');
        if ($imagePath) {
            $projeto->setImagem($imagePath);
        }

        // Participantes e Tecnologias selecionados no formulário
        $participantesIds = $data['participantes'] ?? [];
        $tecnologiasIds = $data['tecnologias'] ?? [];

        // Salva o projeto e suas relações
        // O método save no repositório precisará ser inteligente para lidar com isso
        $this->ltdProjetoRepository->save($projeto, $participantesIds, $tecnologiasIds);

        Flash::set('message', 'Projeto LTD cadastrado com sucesso!');
        header('Location: ' . BASE_URL . '/admin/ltd');
        exit;
    }
    
    // Aqui viriam os outros métodos: edit, update e destroy, seguindo um padrão similar.
    public function edit(Request $request, $params)
    {
        $id = $params['id'] ?? null;
        if (!$id) {
            Flash::set('message', 'Projeto não encontrado.');
            header('Location: ' . BASE_URL . '/admin/ltd');
            exit;
        }

        $projeto = $this->ltdProjetoRepository->findById($id);
        if (!$projeto) {
            Flash::set('message', 'Projeto não encontrado.');
            header('Location: ' . BASE_URL . '/admin/ltd');
            exit;
        }

        $todosUsuarios = $this->usuarioRepository->findAll();
        $todasTecnologias = $this->tecnologiaRepository->findAll();

        return $this->view->render('admin/ltd/form', [
            'title' => 'Editar Projeto LTD',
            'action' => BASE_URL . '/admin/ltd/edit/' . $projeto->getId(),
            'projeto' => $projeto,
            'todos_usuarios' => $todosUsuarios,
            'todas_tecnologias' => $todasTecnologias,
            'projeto_participantes_ids' => array_map(fn($p) => $p->getId(), $projeto->getParticipantes()),
            'projeto_tecnologias_ids' => array_map(fn($t) => $t->getId(), $projeto->getTecnologias()),
            'button_label' => 'Atualizar Projeto'
        ]);
    }

    public function update(Request $request, $params)
    {
        $id = $params['id'] ?? null;
        if (!$id) {
            Flash::set('message', 'Projeto não encontrado.');
            header('Location: ' . BASE_URL . '/admin/ltd');
            exit;
        }

        $data = $request->getBody();
        $projeto = $this->ltdProjetoRepository->findById($id);
        if (!$projeto) {
            Flash::set('message', 'Projeto não encontrado.');
            header('Location: ' . BASE_URL . '/admin/ltd');
            exit;
        }

        $projeto->setNome($data['nome']);
        $projeto->setDescricao($data['descricao']);
        $projeto->setStatus($data['status']);
        $projeto->setPeriodo($data['periodo']);
        $projeto->setGithub($data['github_url']);

        // Upload da Imagem
        $imagePath = ImageUploader::upload($data, $_FILES, 'ltd_projetos');
        if ($imagePath) {
            $projeto->setImagem($imagePath);
        }

        // Participantes e Tecnologias selecionados no formulário
        $participantesIds = $data['participantes'] ?? [];
        $tecnologiasIds = $data['tecnologias'] ?? [];

        // Atualiza o projeto e suas relações
        $this->ltdProjetoRepository->update($projeto, $participantesIds, $tecnologiasIds);

        Flash::set('message', 'Projeto LTD atualizado com sucesso!');
        header('Location: ' . BASE_URL . '/admin/ltd');
        exit;
    }

    public function findById($id)
    {
        $projeto = $this->ltdProjetoRepository->findById($id);
        if (!$projeto) {
            Flash::set('message', 'Projeto não encontrado.');
            header('Location: ' . BASE_URL . '/admin/ltd');
            exit;
        }
        return $projeto;
    }
}