<?php

namespace App\Controllers;

use App\Utils\Flash;
use App\Utils\View;
use App\Repositories\EducadorRepository;
use App\Models\Usuario; // Importe o modelo Usuario
use App\Models\Perfil; // Importe o modelo Perfil
use App\HTTP\Response;
use App\HTTP\Request;
use App\Database\Pagination; // Para paginação na listagem
use App\Services\ImageUploader; // Para upload de imagens

class AdminEducadoresController
{
    private $educadorRepository;
    private $view;

    public function __construct()
    {
        $this->educadorRepository = new EducadorRepository();
        $this->view = new View();

        // Sugestão: Adicionar verificação de admin para proteger estas rotas
        // if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
        //     header('Location: ' . BASE_URL . '/login');
        //     exit;
        // }
    }

    /**
     * Lista todos os educadores no painel de administração.
     * @param Request $request
     * @return string
     */
    public function index(Request $request): string
    {
        $queryParams = $request->getQueryParams();
        $currentPage = $queryParams['page'] ?? 1;
        $searchTerm = $queryParams['search'] ?? null; // Para a barra de busca

        $totalEducadores = $this->educadorRepository->count($searchTerm);
        $pagination = new Pagination($totalEducadores, $currentPage, 10); // 10 educadores por página

        $educadoresData = $this->educadorRepository->findAll('u.id DESC', $pagination->getLimit(), $searchTerm);

        $content = $this->view->render('admin/educadores/index', [
            'educadores' => $educadoresData,
            'flash' => Flash::get('message'),
            'pagination' => $pagination->getPages(),
            'searchTerm' => $searchTerm
        ]);

        return $content;
    }

    /**
     * Exibe o formulário para criar um novo educador.
     * @return string
     */
    public function create(): string
    {
        $content = $this->view->render('admin/educadores/form', [
            'title' => 'Cadastrar Novo Educador',
            'action' => BASE_URL . '/admin/educadores/create', // Ação para o formulário
            'educador' => ['usuario' => new Usuario(), 'perfil' => new Perfil()], // Educador vazio
            'button_label' => 'Cadastrar'
        ]);

        return $content;
    }

    /**
     * Salva um novo educador no banco de dados.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $data = $request->getBody();
        $fileData = $_FILES;

        // Validação básica (pode ser expandida)
        if (empty($data['username']) || empty($data['email']) || empty($data['senha']) || empty($data['nome_completo'])) {
            Flash::set('message', 'Erro: Preencha todos os campos obrigatórios (Nome de Usuário, E-mail, Senha, Nome Completo).');
            $response = new Response(302, '');
            $response->addHeader('Location', BASE_URL . '/admin/educadores/create');
            return $response;
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            Flash::set('message', 'Erro: E-mail inválido.');
            $response = new Response(302, '');
            $response->addHeader('Location', BASE_URL . '/admin/educadores/create');
            return $response;
        }
        if (strlen($data['senha']) < 6) { // Exemplo de validação de senha
            Flash::set('message', 'Erro: A senha deve ter no mínimo 6 caracteres.');
            $response = new Response(302, '');
            $response->addHeader('Location', BASE_URL . '/admin/educadores/create');
            return $response;
        }


        // Instancia os modelos Usuario e Perfil
        $usuario = new Usuario();
        $perfil = new Perfil();

        // Popula os dados do Usuário
        $usuario->setUsername($data['username']);
        $usuario->setEmail($data['email']);
        $usuario->setSenha($data['senha']); // A senha será hashed no repositório
        $usuario->setIsEducador(true); // Sempre true para educadores
        $usuario->setIsAdmin(isset($data['is_admin']) ? true : false); // Pode ser admin também

        // Popula os dados do Perfil
        $perfil->setNome($data['nome_completo']);
        $perfil->setSobrenome($data['sobrenome'] ?? '');
        $perfil->setCargo($data['cargo'] ?? '');
        $perfil->setBio($data['bio'] ?? '');
        $perfil->setGithub($data['github'] ?? '');
        $perfil->setLinkedin($data['linkedin'] ?? '');

        // Processa o upload da imagem
        $imagePath = ImageUploader::upload($data, $fileData, 'educadores');
        if ($imagePath) {
            $perfil->setFoto($imagePath);
        }

        try {
            $this->educadorRepository->create($usuario, $perfil);
            Flash::set('message', 'Educador cadastrado com sucesso!');
        } catch (\Exception $e) {
            Flash::set('message', 'Erro ao cadastrar educador: ' . $e->getMessage());
        }

        $response = new Response(302, '');
        $response->addHeader('Location', BASE_URL . '/admin/educadores');
        return $response;
    }

    /**
     * Exibe o formulário para editar um educador existente.
     * @param Request $request
     * @param array $params
     * @return string|Response
     */
    public function edit(Request $request, array $params)
    {
        $id = (int)$params['id'];
        $educadorData = $this->educadorRepository->findById($id);

        if (!$educadorData) {
            Flash::set('message', 'Educador não encontrado.');
            $response = new Response(302, '');
            $response->addHeader('Location', BASE_URL . '/admin/educadores');
            return $response;
        }

        // Correção: Mantenha APENAS esta atribuição para $content (removendo a duplicada)
        $content = $this->view->render('admin/educadores/form', [
            'title' => 'Editar Educador',
            'action' => BASE_URL . '/admin/educadores/edit/' . $id, // Ação para o formulário
            'educador' => $educadorData, // Passa os objetos Usuario e Perfil
            'button_label' => 'Salvar Alterações'
        ]);

        return $content;
    }

    /**
     * Atualiza um educador existente no banco de dados.
     * @param Request $request
     * @param array $params
     * @return Response
     */
    public function update(Request $request, array $params): Response
    {
        $id = (int)$params['id'];
        $data = $request->getBody();
        $fileData = $_FILES;

        $educadorData = $this->educadorRepository->findById($id);

        if (!$educadorData) {
            Flash::set('message', 'Educador não encontrado.');
            $response = new Response(302, '');
            $response->addHeader('Location', BASE_URL . '/admin/educadores');
            return $response;
        }

        $usuario = $educadorData['usuario'];
        $perfil = $educadorData['perfil'];

        // Validação básica (pode ser expandida)
        if (empty($data['username']) || empty($data['email']) || empty($data['nome_completo'])) {
            Flash::set('message', 'Erro: Preencha os campos obrigatórios (Nome de Usuário, E-mail, Nome Completo).');
            $response = new Response(302, '');
            $response->addHeader('Location', BASE_URL . '/admin/educadores/edit/' . $id);
            return $response;
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            Flash::set('message', 'Erro: E-mail inválido.');
            $response = new Response(302, '');
            $response->addHeader('Location', BASE_URL . '/admin/educadores/edit/' . $id);
            return $response;
        }
        // Senha: só valida e atualiza se um novo valor for fornecido
        if (!empty($data['senha']) && strlen($data['senha']) < 6) {
            Flash::set('message', 'Erro: A nova senha deve ter no mínimo 6 caracteres.');
            $response = new Response(302, '');
            $response->addHeader('Location', BASE_URL . '/admin/educadores/edit/' . $id);
            return $response;
        }


        // Atualiza os dados do Usuário
        $usuario->setUsername($data['username']);
        $usuario->setEmail($data['email']);
        // A senha só é atualizada se um novo valor for fornecido no formulário
        if (!empty($data['senha'])) {
            $usuario->setSenha(password_hash($data['senha'], PASSWORD_DEFAULT)); // Hash da nova senha
        }
        $usuario->setIsAdmin(isset($data['is_admin']) ? true : false);
        $usuario->setIsEducador(true); // Mantém como educador

        // Atualiza os dados do Perfil
        $perfil->setNome($data['nome_completo']);
        $perfil->setSobrenome($data['sobrenome'] ?? '');
        $perfil->setCargo($data['cargo'] ?? '');
        $perfil->setBio($data['bio'] ?? '');
        $perfil->setGithub($data['github'] ?? '');
        $perfil->setLinkedin($data['linkedin'] ?? '');

        // Processa o upload da nova imagem, deletando a antiga se houver
        $oldImagePath = $perfil->getFoto();
        $newImagePath = ImageUploader::upload($data, $fileData, 'educadores', $oldImagePath);
        if ($newImagePath) {
            $perfil->setFoto($newImagePath);
        } elseif (isset($data['remove_current_image']) && $data['remove_current_image'] == '1') {
            // Se a checkbox "remover imagem" foi marcada e não há nova imagem
            ImageUploader::delete($oldImagePath);
            $perfil->setFoto(null);
        }


        try {
            $this->educadorRepository->update($usuario, $perfil);
            Flash::set('message', 'Educador atualizado com sucesso!');
        } catch (\Exception $e) {
            Flash::set('message', 'Erro ao atualizar educador: ' . $e->getMessage());
        }

        $response = new Response(302, '');
        $response->addHeader('Location', BASE_URL . '/admin/educadores');
        return $response;
    }

    /**
     * Exibe a página de confirmação para deletar um educador.
     * @param Request $request
     * @param array $params
     * @return string|Response
     */
    public function delete(Request $request, array $params)
    {
        $id = (int)$params['id'];
        $educadorData = $this->educadorRepository->findById($id);

        if (!$educadorData) {
            Flash::set('message', 'Educador não encontrado.');
            $response = new Response(302, '');
            $response->addHeader('Location', BASE_URL . '/admin/educadores');
            return $response;
        }

        $content = $this->view->render('admin/educadores/delete', [
            'educador' => $educadorData
        ]);
        return $content;
    }

    /**
     * Deleta um educador do banco de dados.
     * @param Request $request
     * @param array $params
     * @return Response
     */
    public function destroy(Request $request, array $params): Response
    {
        $id = (int)$params['id'];
        // O findById aqui serve para garantir que o educador existe antes de tentar deletar
        // E também pode ser usado para pegar o caminho da imagem e deletá-la
        $educadorData = $this->educadorRepository->findById($id);

        if (!$educadorData) {
            Flash::set('message', 'Educador não encontrado.');
            $response = new Response(302, '');
            $response->addHeader('Location', BASE_URL . '/admin/educadores');
            return $response;
        }

        try {
            // O ON DELETE CASCADE deve lidar com o perfil.
            // Mas a imagem precisa ser deletada manualmente.
            if ($educadorData['perfil']->getFoto()) {
                ImageUploader::delete($educadorData['perfil']->getFoto());
            }
            $this->educadorRepository->delete($id);
            Flash::set('message', 'Educador deletado com sucesso!');
        } catch (\Exception $e) {
            Flash::set('message', 'Erro ao deletar educador: ' . $e->getMessage());
        }
        
        $response = new Response(302, '');
        $response->addHeader('Location', BASE_URL . '/admin/educadores');
        return $response;
    }
}