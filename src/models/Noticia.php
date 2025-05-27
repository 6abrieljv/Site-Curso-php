<?php

class Noticia{
    private $id;
    private $titulo;
    private $conteudo;
    private $dataPublicacao;
    private $imagem;
    private $idAutor;

    public function __construct($titulo, $conteudo, $imagem = null, $idAutor = null, $id = null)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->conteudo = $conteudo;
        $this->dataPublicacao = date('Y-m-d', strtotime('now'));
        $this->imagem = $imagem;
        $this->idAutor = $idAutor;
    }
}