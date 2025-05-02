<?php
$nomeCompleto = $_POST['nome_completo'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$confirmarSenha = $_POST['confirmar_senha'];



require_once '../../model/Conexao.php';
require_once '../../model/Usuario.php';
require_once '../dao/UsuarioDao.php';
require_once '../dao/PerfilDao.php';
require_once '../../model/Perfil.php';

// Verificar se as senhas coincidem
if ($senha !== $confirmarSenha) {
    header('Location: ../../view/Cadastro.php?erro=senhas_nao_coincidem');
    exit;
}

// Criar o objeto Usuario e salvar no banco
$usuario = new Usuario($email, $senha, $nomeCompleto);
$usuario->setNome($nomeCompleto); // Define o nome do usuário
$usuario->setEmail($email); // Define o email do usuário
$usuario->setSenha($senha); // Define a senha do usuário    
$conexao = new Conexao();
$usuarioDao = new UsuarioDao($conexao->conectar(), $usuario);
$perfil = new Perfil(null, 'Nova bio', 'https://i.pinimg.com/736x/6d/13/0f/6d130f1e2a5e7f6f8829718fb37cf02c.jpg');




if ($usuarioDao->inserir($perfil)) {
    header('Location: ../../index.php?sucesso=cadastro_realizado');
    exit;
} else {
    header('Location: ../../view/Cadastro.php?erro=erro_ao_cadastrar');
    exit;
}
?>