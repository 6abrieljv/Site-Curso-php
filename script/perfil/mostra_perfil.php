<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php'); // Redireciona para o login se não estiver logado
    exit;
}

require_once '../model/Conexao.php';
require_once '../script/dao/PerfilDao.php';
require_once '../model/Perfil.php';

// Obtém o ID do usuário logado
$idUsuario = $_SESSION['id_usuario'];

// Conexão com o banco de dados
$conexao = new Conexao();
$pdo = $conexao->conectar();

// Busca os dados do perfil do usuário logado
$query = "SELECT *
          FROM perfil 
          INNER JOIN usuario ON perfil.id_usuario = usuario.id 
          WHERE perfil.id_usuario = :id_usuario";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':id_usuario', $idUsuario, PDO::PARAM_INT);
$stmt->execute();
$perfil = $stmt->fetch(PDO::FETCH_ASSOC);

// Define valores padrão caso o perfil não tenha informações completas
$nome = $perfil['nome'] ?? 'Usuário';
$foto = $perfil['foto'] ?? 'assets/img/default.png'; // Foto padrão
$descricao = $perfil['bio'] ?? 'Nenhuma descrição disponível.';
?>