<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php'); // Redireciona para o login se não estiver logado
    exit;
}

require_once '../model/Conexao.php'; 
require_once '../script/dao/PerfilDao.php'; 
require_once "../model/Perfil.php"; 

$idUsuario = $_SESSION['id_usuario'];
$nomeUsuario = $_SESSION['nome'];
$perfil = new Perfil($idUsuario, '', ''); // Cria um objeto Perfil com o ID do usuário
$conexao = new Conexao();
$perfilDao = new PerfilDao($conexao->conectar(), $perfil); // Passa o objeto PDO para o PerfilDao

// Busca os dados do perfil
$query = "SELECT foto FROM perfil WHERE id_usuario = :id_usuario";
$stmt = $conexao->conectar()->prepare($query);
$stmt->bindValue(':id_usuario', $idUsuario);
$stmt->execute();
$perfil = $stmt->fetch(PDO::FETCH_ASSOC);

// Exibe o nome e a foto
$fotoPerfil = $perfil['foto'] ?? 'default.png'; // Foto padrão se não houver foto no perfil
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <h1 class="">Bem-vindo, <?php echo htmlspecialchars($nomeUsuario); ?>!</h1>
    <img src="<?php echo htmlspecialchars($fotoPerfil); ?>" alt="Foto de Perfil"
        style="width: 150px; height: 150px; border-radius: 50%;">
    <a href="NoticiaCadastro.php">Cadastrar Perfil</a>
    <a href="Noticia.php">Notícia</a>
</body>

</html>