<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <title>Cadastrar Noticia</title>

</head>

<body>
    <h1>Cadastrar Noticia</h1>
    <form method="POST" action="../script/noticia/processa_noticia.php" enctype="multipart/form-data">

        <div class="input-login">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>
        </div>

        <div class="input-login">
            <label for="texto">Texto:</label>
            <textarea id="texto" name="texto" required></textarea>
        </div>

        <div class="input-login">
            <label for="imagem">Imagem:</label>
            <input type="file" id="imagem" name="imagem" accept=".jpg, .jpeg, .png, .gif">
        </div>

        <button type="submit" class="login-btn">Cadastrar Notícia</button>
    </form>

</body>

</html>