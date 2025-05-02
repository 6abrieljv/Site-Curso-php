<?php
$nomeCompleto = $_POST['nome_completo'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$confirmarSenha = $_POST['confirmar_senha'];

require_once '../../model/Conexao.php';
require_once '../../model/Usuario.php';
require_once '../dao/UsuarioDao.php';

// Verificar se as senhas coincidem
if ($senha !== $confirmarSenha) {
    header('Location: ../../view/Cadastro.php?erro=senhas_nao_coincidem');
    exit;
}

// Criar o objeto Usuario e salvar no banco
$usuario = new Usuario($email, $senha);
$conexao = new Conexao();
$usuarioDao = new UsuarioDao($conexao->conectar(), $usuario);

if ($usuarioDao->inserir()) {
    header('Location: ../../index.php?sucesso=cadastro_realizado');
    exit;
} else {
    header('Location: ../../view/Cadastro.php?erro=erro_ao_cadastrar');
    exit;
}
?>