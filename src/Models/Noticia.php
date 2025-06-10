<?php

namespace App\Models;

use DateTime;
use App\Utils\StringUtils;

class Noticia
{
    private  $id = null;
    private  $titulo = null;
    private  $conteudo = null;
    private  $slug = null;
    private  $data_publicacao = null;
    private  $id_categoria = null;
    private  $id_usuario = null;
    private  $imagem = null; // Caminho para a imagem

    private  $usuario = null;
    private  $categoria = null;




    public function getId()
    {
        return $this->id;
    }
    public function setId($value)
    {
        $this->id = $value;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }
    public function setTitulo($value)
    {
        $this->titulo = $value;
    }

    public function getConteudo()
    {
        return $this->conteudo;
    }
    public function setConteudo($value)
    {
        $this->conteudo = $value;
    }

    public function getSlug()
    {
        return $this->slug;
    }
    public function setSlug($value)
    {
        $this->slug = $value;
    }

    public function getDataPublicacao()
    {
        return $this->data_publicacao;
    }
    public function setDataPublicacao($value)
    {
        $this->data_publicacao = $value;
    }

    public function getIdCategoria()
    {
        return $this->id_categoria;
    }
    public function setIdCategoria($value)
    {
        $this->id_categoria = $value;
    }

    public function getIdUsuario()
    {
        return $this->id_usuario;
    }
    public function setIdUsuario($value)
    {
        $this->id_usuario = $value;
    }

    public function getImagem()
    {
        return $this->imagem;
    }
    public function setImagem($value)
    {
        $this->imagem = $value;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }
    public function setUsuario($value)
    {
        $this->usuario = $value;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }
    public function setCategoria($value)
    {
        $this->categoria = $value;
    }
}
