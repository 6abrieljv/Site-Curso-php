<?php

class Noticia{
    public ?int $id;
    public ?int $id_usuario;

    public ?int $id_categoria;

    public ?Usuario $usuario;
    public ?Categoria $categoria;
    public ?string $titulo;
    public ?string $slug;
    public ?string $conteudo;
    public ?string $imagem;
    public ?string $data_publicacao;



    
}