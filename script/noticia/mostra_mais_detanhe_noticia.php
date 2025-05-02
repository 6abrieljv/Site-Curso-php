<?php
require_once '../model/Conexao.php';
require_once '../model/Noticia.php';
require_once '../script/dao/NoticiaDao.php';

// Verifica se o ID foi passado
$id = $_GET['id'] ?? null;
if (!$id) {
    die("Erro: ID da notícia não fornecido.");
}

// Conexão com o banco de dados
$conexao = new Conexao();
$pdo = $conexao->conectar();

// Instância do DAO
$noticiaDao = new NoticiaDao($pdo, new Noticia('', '', '', '', ''));

// Busca a notícia pelo ID
$noticia = $noticiaDao->buscarPorId($id);
if (!$noticia) {
    die("Erro: Notícia não encontrada.");
}
?>