<?php

class Noticia{
    private $id;
    private $titulo;
    private $conteudo;
    private $dataPublicacao;
    private $imagem;
    private $idUsuario;

    public function __construct($titulo, $conteudo, $imagem = null, $idUsuario = null, $id = null)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->conteudo = $conteudo;
        $this->dataPublicacao = date('Y-m-d', strtotime('now'));
        $this->imagem = $imagem;
        $this->idUsuario = $idUsuario;
    }
}