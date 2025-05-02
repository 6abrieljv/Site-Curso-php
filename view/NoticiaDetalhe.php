<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <title>Detalhes da Notícia</title>
    <style>
        body {
            font-family: 'Press Start 2P', cursive;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .noticia-detalhe-container {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 24px;
            max-width: 800px;
            width: 90%;
            text-align: center;
        }

        .noticia-detalhe-container img {
            max-width: 100%;
            border-radius: 12px;
            margin-bottom: 16px;
        }

        .noticia-detalhe-container h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 16px;
        }

        .noticia-detalhe-container p {
            font-size: 14px;
            color: #555;
            line-height: 1.6;
            margin-bottom: 16px;
        }

        .noticia-detalhe-container a {
            display: inline-block;
            margin-top: 16px;
            padding: 10px 20px;
            background-color: #003366;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .noticia-detalhe-container a:hover {
            background-color: #002750;
        }

        .noticia-detalhe-container .data-publicacao {
            font-size: 12px;
            color: #888;
            margin-top: 8px;
        }
    </style>
</head>

<body>
    <?php require '../script/noticia/mostra_mais_detanhe_noticia.php'; // Inclui o arquivo PHP separado ?>
    <div class="noticia-detalhe-container">
        <h1><?php echo htmlspecialchars($noticia['titulo'], ENT_QUOTES, 'UTF-8'); ?></h1>
        <?php if (!empty($noticia['imagem'])): ?>
        <img src="../<?php echo htmlspecialchars($noticia['imagem'], ENT_QUOTES, 'UTF-8'); ?>" alt="Imagem da notícia">
        <?php endif; ?>
        <p><?php echo nl2br(htmlspecialchars($noticia['conteudo'], ENT_QUOTES, 'UTF-8')); ?></p>
        <p class="data-publicacao"><strong>Data de publicação:</strong>
            <?php echo htmlspecialchars($noticia['data_publicacao'], ENT_QUOTES, 'UTF-8'); ?></p>
        <a href="Noticia.php">Voltar</a>
    </div>
</body>

</html>