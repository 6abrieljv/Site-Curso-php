<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php'); // Redireciona para o login se não estiver logado
    exit;
}

require_once '../model/Conexao.php';

// Obtém o ID do usuário logado
$idUsuario = $_SESSION['id_usuario'];

// Conexão com o banco de dados
$conexao = new Conexao();
$pdo = $conexao->conectar();

// Busca os dados do perfil do usuário logado
$query = "SELECT bio, foto FROM perfil WHERE id_usuario = :id_usuario";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':id_usuario', $idUsuario, PDO::PARAM_INT);
$stmt->execute();
$perfil = $stmt->fetch(PDO::FETCH_ASSOC);

// Define valores padrão caso o perfil não tenha informações completas
$descricao = $perfil['bio'] ?? '';
$foto = $perfil['foto'] ?? 'assets/img/default.png'; // Foto padrão

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = $_POST['descricao'] ?? '';
    $novaFoto = '';

    // Verifica se um arquivo foi enviado
    if (!empty($_FILES['foto']['name'])) {
        $diretorio = '../assets/img/';
        $nomeArquivo = 'img_' . uniqid() . '.' . pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $caminhoCompleto = $diretorio . $nomeArquivo;

        // Faz o upload do arquivo
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoCompleto)) {
            $novaFoto = 'assets/img/' . $nomeArquivo;
        }
    }

    // Atualiza os dados no banco de dados
    $query = "UPDATE perfil 
              SET bio = :descricao" . (!empty($novaFoto) ? ", foto = :foto" : "") . " 
              WHERE id_usuario = :id_usuario";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':descricao', $descricao, PDO::PARAM_STR);
    $stmt->bindValue(':id_usuario', $idUsuario, PDO::PARAM_INT);

    if (!empty($novaFoto)) {
        $stmt->bindValue(':foto', $novaFoto, PDO::PARAM_STR);
    }

    if ($stmt->execute()) {
        // Redireciona de volta para a página de perfil com uma mensagem de sucesso
        header('Location: perfil.php?status=sucesso');
        exit;
    } else {
        // Redireciona de volta para a página de edição com uma mensagem de erro
        header('Location: editarPerfil.php?status=erro');
        exit;
    }
}
?>