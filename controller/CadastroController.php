<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once __DIR__ . '/../src/model/Conexao.php';
require_once __DIR__ . '/../src/model/Noticia.php';
require_once __DIR__ . '/../src/model/Perfil.php';
require_once __DIR__ . '/../src/model/Usuario.php';


$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader);

$erro = null;
$sucesso = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeCompleto = $_POST['nome_completo'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmarSenha = $_POST['confirmar_senha'] ?? '';

    if ($senha !== $confirmarSenha) {
        $erro = 'senhas_nao_coincidem';
    } else {
        $usuario = new Usuario($email, $senha, $nomeCompleto);
        $usuario->setNome($nomeCompleto);
        $usuario->setEmail($email);
        $usuario->setSenha($senha);
        $conexao = new Conexao();
        $usuarioDao = new UsuarioDao($conexao->conectar(), $usuario);
        $perfil = new Perfil(null, 'Nova bio', 'https://i.pinimg.com/736x/6d/13/0f/6d130f1e2a5e7f6f8829718fb37cf02c.jpg');

        if ($usuarioDao->inserir($perfil)) {
            $sucesso = 'cadastro_realizado';
        } else {
            $erro = 'erro_ao_cadastrar';
        }
    }
}

// Renderiza o template passando erros e sucesso
echo $twig->render('cadastro.twig', [
    'erro' => $erro,
    'sucesso' => $sucesso
]);
