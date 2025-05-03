<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Estácio</title>
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

    .user-icon img {
        height: 30px;
        border-radius: 50%;
    }

    main {
        display: flex;
        padding: 20px;
        gap: 20px;
    }

    .sidebar {
        background: white;
        width: 250px;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
    }

    .profile-pic {
        position: relative;
        display: inline-block;
    }

    .profile-pic img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
    }

    .edit-icon {
        position: absolute;
        bottom: 5px;
        right: 5px;
        background: #002c54;
        color: white;
        border-radius: 50%;
        padding: 6px 8px;
        font-size: 14px;
        cursor: pointer;
    }

    .sidebar h2 {
        margin-top: 15px;
        font-weight: bold;
        font-family: monospace;
        font-size: 24px;
    }

    .sidebar p {
        color: #333;
        margin-bottom: 20px;
        font-family: monospace;
    }

    .sidebar button {
        background-color: #002c54;
        color: white;
        border: none;
        padding: 10px 20px;
        font-family: monospace;
        font-size: 18px;
        border-radius: 5px;
        cursor: pointer;
    }

    .profile-details {
        background: white;
        flex: 1;
        padding: 20px;
        border-radius: 10px;
        border: 2px solid #0077cc;
    }

    .profile-details h2 {
        margin-bottom: 15px;
        font-size: 22px;
    }

    .profile-details p {
        color: #333;
        line-height: 1.6;
    }
    </style>
</head>

<body>
    <?php require '../script/perfil/mostra_perfil.php'; // Inclui o arquivo PHP separado ?>

    <header>
        <div class="logo">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b6/Est%C3%A1cio_Positivo.png/600px-Est%C3%A1cio_Positivo.png"
                alt="Logo Estácio">
            <span>Estácio</span>
        </div>
        <nav>
            <a href="Home.php">Home</a>
            <a href="#">LTD</a>
            <a href="Noticia.php">Educadores</a>
            <a href="#">Atlética</a>
            <a href="Perfil.php">Perfil</a>
            <div class="user-icon">
                <?php
                if (!empty($foto) && file_exists('../' . $foto)) {
                    // Verifica se a imagem existe localmente
                    echo '<img src="../' . htmlspecialchars($foto, ENT_QUOTES, 'UTF-8') . '" alt="Foto do usuário">';
                } else {
                    // Exibe uma imagem padrão de um link externo
                    echo '<img src="https://via.placeholder.com/150.png?text=Foto+Padrão" alt="Foto padrão">';
                }
                ?>
            </div>
        </nav>
    </header>

    <main>
        <aside class="sidebar">
            <div class="profile-pic">
                <?php
                if (!empty($foto) && file_exists('../' . $foto)) {
                    // Verifica se a imagem existe localmente
                    echo '<img src="../' . htmlspecialchars($foto, ENT_QUOTES, 'UTF-8') . '" alt="Foto do usuário">';
                } else {
                    // Exibe uma imagem padrão de um link externo
                    echo '<img src="https://i.pinimg.com/736x/6d/13/0f/6d130f1e2a5e7f6f8829718fb37cf02c.jpg" alt="Foto padrão">';
                }
                ?>
                <div class="edit-icon">✎</div>
            </div>
            <h2><?php echo htmlspecialchars($nome); ?></h2>
            <a href="editarPerfil.php">Editar</a>
            <button>Editar perfil</button>
        </aside>

        <section class="profile-details">
            <h2>Olá, meu nome é <?php echo htmlspecialchars($nome); ?>! <span>👍</span></h2>
            <p><?php echo nl2br(htmlspecialchars($descricao)); ?></p>
        </section>
    </main>

</body>

</html>