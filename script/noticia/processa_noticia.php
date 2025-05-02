<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');

// Validação dos dados do formulário
$titulo = $_POST['titulo'] ?? null;
$texto = $_POST['texto'] ?? null;
$idAutor = $_SESSION['id_usuario'] ?? null;

if (!$titulo || !$texto || !$idAutor) {
    die("Erro: Todos os campos obrigatórios devem ser preenchidos.");
}

// Sanitização de entrada
$titulo = htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8');
$texto = htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');

// Upload de imagem
$caminhoImagemRelativo = null;
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    $imagemTemp = $_FILES['imagem']['tmp_name'];
    $imagemTipo = mime_content_type($imagemTemp);
    $imagemTamanho = $_FILES['imagem']['size'];
    $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
    $tamanhoMaximo = 2 * 1024 * 1024; // 2MB

    if (!in_array($imagemTipo, $tiposPermitidos)) {
        die("Erro: Tipo de imagem não permitido. Apenas JPG, PNG e GIF são aceitos.");
    }

    if ($imagemTamanho > $tamanhoMaximo) {
        die("Erro: Imagem muito grande. Tamanho máximo: 2MB.");
    }

    // Nome seguro e único
    $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
    $novoNome = uniqid('img_', true) . '.' . $extensao;

    $diretorioDestino = '../../assets/img/';
    if (!is_dir($diretorioDestino)) {
        mkdir($diretorioDestino, 0755, true);
    }

    $caminhoImagemCompleto = $diretorioDestino . $novoNome;
    $caminhoImagemRelativo = 'assets/img/' . $novoNome;

    if (!move_uploaded_file($imagemTemp, $caminhoImagemCompleto)) {
        die("Erro: Falha ao salvar a imagem.");
    }
}

// Carregamento das dependências
require_once '../../model/Conexao.php';
require_once '../../model/Noticia.php';
require_once '../dao/NoticiaDao.php';

// Criação do objeto notícia
$noticia = new Noticia(
    $titulo,
    $texto,
    date('Y-m-d H:i:s'),
    $caminhoImagemRelativo,
    $idAutor
);

// Registro no banco
$conexao = new Conexao();
$pdo = $conexao->conectar();
$noticiaDao = new NoticiaDao($pdo, $noticia);

if ($noticiaDao->cadastrar($noticia)) {
    echo "Notícia cadastrada com sucesso!";
    // Redirecionar para a página inicial ou outra página desejada
    header('Location: ../../index.php?sucesso=cadastro_noticia');
    exit;
} else {
    echo "Erro ao cadastrar a notícia.";
}
?>