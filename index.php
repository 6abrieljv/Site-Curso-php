<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NerdHub</title>

    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Curso_Site/css/style.css">
</head>

<body>
    <div class="container-login">

        <section class="login-container">
            <h1>Bem-Vindo!</h1>
            <p>Faça seu Login</p>

            <?php
            if (isset($_GET['erro'])) {
                if ($_GET['erro'] == 'campos_vazios') {
                    echo "<p style='color: red;'>Preencha todos os campos.</p>";
                } elseif ($_GET['erro'] == 'login_invalido') {
                    echo "<p style='color: red;'>Usuário ou senha inválidos.</p>";
                }
            }

            if (isset($_GET['sucesso']) && $_GET['sucesso'] == 'login_realizado') {
                echo "<p style='color: green;'>Login realizado com sucesso!</p>";
            }
            ?>

            <form method="POST" action="script/login/Processa_login.php">
                <div class="input-login">
                    <label for="usuario">Usuário</label>
                    <input type="text" id="usuario" name="email">
                </div>

                <div class="input-login">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha">
                    <a href="#">Esqueceu a senha?</a>
                </div>

                <button type="submit" class="login-btn">Entrar</button>

                <div class="cadastro-link">
                    <p>Ainda não tem cadastro? <a href="view/Cadastro.php">Cadastre-se aqui</a></p>
                </div>
            </form>

        </section>

        <div class="imagem-login">
            <img class="img-login" src="assets/login.png" alt="imagem de 
        login">
        </div>

    </div>
</body>

</html>