<?php 
$email = $_POST['email'];
$senha = $_POST['senha'];

require_once '../../model/Conexao.php';
require_once '../../model/Usuario.php';
require_once '../dao/UsuarioDao.php';

// Verificar se os campos estão preenchidos
if (empty($email) || empty($senha)) {
    header('Location: ../../index.php?erro=campos_vazios');
    exit;
}

$usuario = new Usuario($email, $senha);
$conexao = new Conexao();
$usuarioDao = new UsuarioDao($conexao->conectar(), $usuario);

// Tentar autenticar o usuário
if ($usuarioDao->login($usuario)) {
    session_start();
    $_SESSION['usuario'] = $usuario->getEmail(); // Armazena o email do usuário na sessão
    header('Location: ../../view/Home.php?sucesso=login_realizado'); // Redireciona para a página inicial
    exit;
} else {
    header('Location: ../../index.php?erro=login_invalido'); // Redireciona para a página de login com erro
    exit;
}
?>