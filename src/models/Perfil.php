<?php

class Perfil{
    private $id;
    private $nome;
    private $sobrenome;
    private $bio;
    private $foto;
    private $dataCriacao;
    private $dataAtualizacao;
    private $ativo;
    private $idUsuario;

    private $instagram;
    private $facebook;
    private $twitter;
    private $linkedin;
    private $github;
    private $youtube;
    private $tiktok;

    public function __construct($id, $nome, $sobrenome, $bio, $foto) {
        $this->id = $id;
        $this->nome = $nome;
        $this->sobrenome = $sobrenome;
        $this->bio = $bio;
        $this->foto = $foto;
        
    }
    


}