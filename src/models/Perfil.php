<?php

class Perfil{
    private $id;
    private $nome;
    private $sobrenome;
    private $bio;
    private $foto;

    public function __construct($id, $nome, $sobrenome, $bio, $foto) {
        $this->id = $id;
        $this->nome = $nome;
        $this->sobrenome = $sobrenome;
        $this->bio = $bio;
        $this->foto = $foto;
    }
    


}