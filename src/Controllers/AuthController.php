<?php

namespace App\Controllers;

use App\Utils\View;
use App\Utils\Flash;
use app\HTTP\Request;

use App\HTTP\Response;
use App\Models\Usuario;
use App\Repositories\UsuarioRepository;



class AuthController
{
    private $usuarioRepository;

    public function __construct()
    {
        $this->usuarioRepository = new UsuarioRepository();
    }

    /**
     * Exibe o formulário de login.
     */
    public function showLoginForm()
    {
        if (isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/');
            exit;
        }

        $content = (new View())->render('auth/login', [
            'flash' => Flash::get('message')
        ]);
        return new Response(200, $content);
    }

    /**
     * Processa a tentativa de login.
     */
    public function login(Request $request)
    {
        $data = $request->getBody();
        $email = $data['email'] ?? '';
        $senha = $data['senha'] ?? '';

        $usuario = $this->usuarioRepository->findByEmail($email);

        if ($usuario && password_verify($senha, $usuario->getSenha())) {
            // Login bem-sucedido, armazena dados do usuário na sessão
            $_SESSION['user'] = [
                'id' => $usuario->getId(),
                'username' => $usuario->getUsername(),
                'is_admin' => $usuario->isAdmin()
            ];
            header('Location: ' . BASE_URL . '/');
            exit;
        }

        // Falha no login
        Flash::set('message', 'E-mail ou senha inválidos.');
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    /**
     * Exibe o formulário de registro.
     */
    public function showRegisterForm()
    {
        if (isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/');
            exit;
        }

        $content = (new View())->render('auth/register', [
            'flash' => Flash::get('message')
        ]);
        return new Response(200, $content);
    }

    /**
     * Processa o registro de um novo usuário.
     */
    public function register($request)
    {
        $data = $request->getBody();
        $username = $data['username'];
        $email = $data['email'];
        $senha = $data['senha'];
        $confirmarSenha = $data['confirmar_senha'];

        // Validações
        if ($senha !== $confirmarSenha) {
            Flash::set('message', 'As senhas não coincidem.');
            header('Location: ' . BASE_URL . '/register');
            exit;
        }

        if ($this->usuarioRepository->findByEmail($email)) {
            Flash::set('message', 'Este e-mail já está em uso.');
            header('Location: ' . BASE_URL . '/register');
            exit;
        }

        // Cria o usuário
        $usuario = new Usuario();
        $usuario->setUsername($username);
        $usuario->setEmail($email);
        $usuario->setSenha($senha); // O hashing é feito no repositório

        $this->usuarioRepository->create($usuario);
        
        Flash::set('message', 'Cadastro realizado com sucesso! Faça o login.');
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    /**
     * Faz o logout do usuário.
     */
    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . '/');
        exit;
    }
    
}
