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
?>