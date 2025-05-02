<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <title>Notícias</title>
    <style>
    .noticia-card {
        border: 1px solid #ccc;
        border-radius: 12px;
        /* Bordas arredondadas */
        padding: 12px;
        margin: 12px;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 300px;
        /* Largura fixa menor */
        text-align: center;
        /* Centraliza o conteúdo */
    }

    .noticia-card img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        /* Bordas arredondadas para a imagem */
        margin-bottom: 8px;
    }

    .noticia-card h2 {
        font-size: 16px;
        margin-bottom: 8px;
        color: #333;
    }

    .noticia-card p {
        font-size: 12px;
        color: #555;
        margin-bottom: 12px;
    }

    .noticia-card a {
        display: inline-block;
        margin-top: 8px;
        padding: 8px 12px;
        background-color: #003366;
        color: #fff;
        text-decoration: none;
        border-radius: 6px;
        /* Bordas arredondadas para o botão */
        font-size: 12px;
        transition: background-color 0.3s ease;
    }

    .noticia-card a:hover {
        background-color: #002750;
    }

    .noticias-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 16px;
        /* Espaçamento entre os cards */
    }
    </style>
</head>

<body>
    <h1 style="text-align: center;">Notícias</h1>

    <div class="noticias-container">
        <?php
        require_once '../model/Conexao.php';
        require_once '../model/Noticia.php';
        require_once '../script/dao/NoticiaDao.php';

        // Conexão com o banco de dados
        $conexao = new Conexao();
        $pdo = $conexao->conectar();

        // Instância do DAO
        $noticiaDao = new NoticiaDao($pdo, new Noticia('', '', '', '', ''));

        // Busca todas as notícias
        $noticias = $noticiaDao->listar();

        // Exibe as notícias
        if (!empty($noticias)) {
            foreach ($noticias as $noticia) {
                echo '<div class="noticia-card">';
                echo '<h2>' . htmlspecialchars($noticia['titulo'], ENT_QUOTES, 'UTF-8') . '</h2>';
                if (!empty($noticia['imagem'])) {
                    echo '<img src="../' . htmlspecialchars($noticia['imagem'], ENT_QUOTES, 'UTF-8') . '" alt="Imagem da notícia">';
                }
                echo '<p>' . htmlspecialchars(substr($noticia['conteudo'], 0, 100), ENT_QUOTES, 'UTF-8') . '...</p>';
                echo '<a href="NoticiaDetalhe.php?id=' . htmlspecialchars($noticia['id'], ENT_QUOTES, 'UTF-8') . '">Ler mais</a>';
                echo '</div>';
            }
        } else {
            echo '<p>Nenhuma notícia encontrada.</p>';
        }
        ?>
    </div>
</body>

</html>