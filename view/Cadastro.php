<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - NerdHub</title>

    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container-login">

        <section class="login-container">
            <h1>Bem-Vindo!</h1>
            <p>Faça seu Cadastro</p>

            <?php
            if (isset($_GET['erro'])) {
                if ($_GET['erro'] == 'senhas_nao_coincidem') {
                    echo "<p style='color: red;'>As senhas não coincidem.</p>";
                } elseif ($_GET['erro'] == 'erro_ao_cadastrar') {
                    echo "<p style='color: red;'>Erro ao cadastrar usuário.</p>";
                }
            }

            if (isset($_GET['sucesso']) && $_GET['sucesso'] == 'cadastro_realizado') {
                echo "<p style='color: green;'>Cadastro realizado com sucesso!</p>";
            }
            ?>

            <form method="POST" action="../script/cadastro/processa_cadastro.php">

                <div class="input-login">
                    <label for="nome_completo">Nome Completo:</label>
                    <input type="text" id="nome_completo" name="nome_completo">
                </div>


                <div class="input-login">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">
                </div>

                <div class="input-login">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha">
                </div>

                <div class="input-login">
                    <label for="senhaConfirmar">Confirmar senha:</label>
                    <input type="password" id="senhaConfirmar" name="confirmar_senha">
                </div>

                <button type="submit" class="login-btn">Cadastrar</button>
            </form>

        </section>

        <div class="imagem-login">
            <img class="img-login" src="../assets/login.png" alt="imagem de 
      login">
        </div>

    </div>
</body>

</html>