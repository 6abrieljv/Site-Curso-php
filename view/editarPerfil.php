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
$query = "SELECT * FROM perfil WHERE id_usuario = :id_usuario";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':id_usuario', $idUsuario, PDO::PARAM_INT);
$stmt->execute();
$perfil = $stmt->fetch(PDO::FETCH_ASSOC);

// Define valores padrão caso o perfil não tenha informações completas
$foto = $perfil['foto'] ?? 'assets/img/default.png'; // Foto padrão
$descricao = $perfil['bio'] ?? '';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = $_POST['descricao'] ?? '';
    $novaFoto = '';

    // Verifica se uma nova foto foi enviada
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
        // Redireciona para a página de perfil com uma mensagem de sucesso
        header('Location: perfil.php?status=sucesso');
        exit;
    } else {
        // Redireciona para a página de edição com uma mensagem de erro
        header('Location: editarPerfil.php?status=erro');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - Estácio</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', sans-serif;
    }

    body {
        background-color: #f0f0f0;
    }

    header {
        background-color: #002c54;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 30px;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .logo img {
        height: 25px;
    }

    nav {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    nav a {
        color: white;
        text-decoration: none;
        font-family: monospace;
    }

    main {
        display: flex;
        justify-content: center;
        padding: 20px;
    }

    .edit-container {
        background: white;
        width: 400px;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .edit-container h2 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 24px;
        color: #002c54;
    }

    .edit-container label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
    }

    .edit-container input,
    .edit-container textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
    }

    .edit-container button {
        width: 100%;
        padding: 10px;
        background-color: #002c54;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    .edit-container button:hover {
        background-color: #001a3a;
    }

    .profile-pic-preview {
        text-align: center;
        margin-bottom: 20px;
    }

    .profile-pic-preview img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
    }
    </style>
</head>

<body>

    <header>
        <div class="logo">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b6/Est%C3%A1cio_Positivo.png/600px-Est%C3%A1cio_Positivo.png"
                alt="Logo Estácio">
            <span>Estácio</span>
        </div>
        <nav>
            <a href="perfil.php">Voltar ao Perfil</a>
        </nav>
    </header>

    <main>
        <div class="edit-container">
            <h2>Editar Perfil</h2>
            <form action="editarPerfil.php" method="POST" enctype="multipart/form-data">
                <div class="profile-pic-preview">
                    <?php
                    if (!empty($foto) && file_exists('../' . $foto)) {
                        echo '<img src="../' . htmlspecialchars($foto, ENT_QUOTES, 'UTF-8') . '" alt="Foto do usuário">';
                    } else {
                        echo '<img src="https://via.placeholder.com/150.png?text=Foto+Padrão" alt="Foto padrão">';
                    }
                    ?>
                </div>

                <label for="descricao">Descrição</label>
                <textarea id="descricao" name="descricao" rows="4"
                    required><?php echo htmlspecialchars($descricao); ?></textarea>

                <label for="foto">Foto de Perfil</label>
                <input type="file" id="foto" name="foto" accept="image/*">

                <button type="submit">Salvar Alterações</button>
            </form>
        </div>
    </main>

</body>

</html>