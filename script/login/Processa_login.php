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

$usuario = new Usuario('', '', '', $email, $senha); // Cria o objeto Usuario com os dados do login
$usuario->setEmail($email); // Define o email do usuário
$usuario->setSenha($senha); // Define a senha do usuário
$conexao = new Conexao();
$usuarioDao = new UsuarioDao($conexao->conectar(), $usuario);

// Tentar autenticar o usuário
$resultado = $usuarioDao->login($usuario);
if ($resultado) {
    session_start();
    $_SESSION['id_usuario'] = $resultado['id']; // Armazena o ID do usuário
    $_SESSION['nome'] = $resultado['nome']; // Armazena o nome completo do usuário
    header('Location: ../../view/Home.php'); // Redireciona para a página inicial
    exit;
} else {
    header('Location: ../../index.php?erro=login_invalido'); // Redireciona para a página de login com erro
    exit;
}
?>