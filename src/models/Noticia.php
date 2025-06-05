<?php

class Noticia{
    private ?int $id = null;
    private ?int $id_usuario = null;

    private ?int $id_categoria = null;

    private ?Usuario $usuario = null;
    private ?Categoria $categoria = null;
    private ?string $titulo = null;
    private ?string $slug = null;
    private ?string $conteudo = null;
    private ?string $imagem = null;
    private ?string $data_publicacao = null;

    public function __construct(
        ?int $id = null,
        ?int $id_usuario = null,
        ?int $id_categoria = null,
        ?Usuario $usuario = null,
        ?Categoria $categoria = null,
        ?string $titulo = null,
        ?string $conteudo = null,
        ?string $imagem = null,
        ?string $data_publicacao = null
    ) {
        $this->id = $id;
        $this->id_usuario = $id_usuario;
        $this->id_categoria = $id_categoria;
        $this->usuario = $usuario;
        $this->categoria = $categoria;
        $this->titulo = $titulo;
        $this->slug = $titulo !== null ? StringUtils::slugify($titulo) : null;
        $this->conteudo = $conteudo;
        $this->imagem = $imagem;
        $this->data_publicacao = $data_publicacao;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getIdUsuario(): ?int
    {
        return $this->id_usuario;
    }

    public function setIdUsuario(?int $id_usuario): void
    {
        $this->id_usuario = $id_usuario;
    }

    public function getIdCategoria(): ?int
    {
        return $this->id_categoria;
    }

    public function setIdCategoria(?int $id_categoria): void
    {
        $this->id_categoria = $id_categoria;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): void
    {
        $this->usuario = $usuario;
    }

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): void
    {
        $this->categoria = $categoria;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(?string $titulo): void
    {
        $this->titulo = $titulo;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    public function getConteudo(): ?string
    {
        return $this->conteudo;
    }

    public function setConteudo(?string $conteudo): void
    {
        $this->conteudo = $conteudo;
    }

    public function getImagem(): ?string
    {
        return $this->imagem;
    }

    public function setImagem(?string $imagem): void
    {
        $this->imagem = $imagem;
    }

    public function getDataPublicacao(): ?string
    {
        return $this->data_publicacao;
    }

    public function setDataPublicacao(?string $data_publicacao): void
    {
        $this->data_publicacao = $data_publicacao;
    }


}