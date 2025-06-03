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
$fotoPerfil = $perfil['foto'] ?? 'assets/img/default.png'; // Foto padrão se não houver foto no perfil
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
    body {
        font-family: 'Press Start 2P', cursive;
        background-color: #f9f9f9;
        text-align: center;
        padding: 20px;
    }

    img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        margin: 20px 0;
    }

    a {
        display: inline-block;
        margin: 10px;
        padding: 10px 20px;
        background-color: #002c54;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-size: 14px;
    }

    a:hover {
        background-color: #001a3a;
    }
    </style>
</head>

<body>
    <h1>Bem-vindo, <?php echo htmlspecialchars($nomeUsuario); ?>!</h1>
    <div>
        <?php
        if (!empty($fotoPerfil) && file_exists('../' . $fotoPerfil)) {
            // Verifica se a imagem existe localmente
            echo '<img src="../' . htmlspecialchars($fotoPerfil, ENT_QUOTES, 'UTF-8') . '" alt="Foto do usuário">';
        } else {
            // Exibe uma imagem padrão de um link externo
            echo '<img src="https://i.pinimg.com/736x/6d/13/0f/6d130f1e2a5e7f6f8829718fb37cf02c.jpg" alt="Foto padrão">';
        }
        ?>
    </div>
    <a href="NoticiaCadastro.php">Cadastrar Notícia</a>
    <a href="Noticia.php">Notícias</a>
    <a href="Perfil.php">Perfil</a>
</body>

</html>