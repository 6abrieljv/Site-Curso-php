<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tela de Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400..700&display=swap" rel="stylesheet">
  <link rel="shortcut icon" type="image/jpg" href="../../public/assets/img/logos/logo.png"/>
</head>

<body class="min-h-screen flex items-center justify-center font-['Pixelify_Sans'] bg-[#f9f9f9]">
  <!-- Container Flutuante -->
  <section class="flex flex-col lg:flex-row w-full max-w-[75%] h-auto lg:h-[80vh] shadow-2xl overflow-hidden bg-white">

    <!-- Login -->
    <div class="w-full lg:w-2/6 flex items-center justify-center p-6 sm:p-10 bg-white border-2 border-black">
      <div class="w-full max-w-sm text-center">
        <h1 class="text-4xl font-bold mb-2">Bem-Vindo!</h1>
        <p class="text-md text-[#333] mb-5">Faça seu Login</p>

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
  
        <form class="space-y-4 text-left">
          <div>
            <label for="email" class="block text-sm font-medium">E-mail</label>
            <input type="email" id="email" name="email" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-900 focus:border-blue-900" />
          </div>
          <div>
            <label for="senha" class="block text-sm font-medium">Senha</label>
            <div class="relative mt-1">
              <input type="password" id="senha" name="senha" required class="block w-full px-4 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-900 focus:border-blue-900" />
              <button type="button" id="toggleSenha" class="absolute inset-y-0 right-2 flex items-center text-gray-600 hover:text-black" tabindex="-1">
                👁️
              </button>
            </div>
          </div>
          
          
          <div class="flex flex-col sm:flex-row sm:items-center justify-between text-sm text-gray-600 gap-2 sm:gap-0">
            <label class="flex items-center">
              <input type="checkbox" class="mr-2"> Lembrar de mim
            </label>
            <a href="#" class="text-blue-600 hover:underline">Esqueceu a senha?</a>
          </div>
          <button type="submit" class="w-full bg-[#001A35] hover:bg-[#013267] text-white py-2 rounded-md transition">Entrar</button>
        </form>
        <p class="mt-4 text-sm text-gray-500 text-center">Não tem uma conta? <a href="#" class="text-blue-600 hover:underline">Cadastre-se</a></p>
      </div>
    </div>
  
    <!--imagem-->
    <div class="hidden lg:block w-4/6 bg-cover bg-center bg-[#001A35]" style="background-image: url('https://source.unsplash.com/800x600/?technology,abstract');">
    </div>
  
  </section>
  
  <script>
    const toggleSenha = document.getElementById("toggleSenha");
    const senhaInput = document.getElementById("senha");
  
    toggleSenha.addEventListener("click", () => {
      const tipo = senhaInput.type === "password" ? "text" : "password";
      senhaInput.type = tipo;
      toggleSenha.textContent = tipo === "password" ? "👁️" : "🙈";
    });
  </script>
  
</body>
</html>
