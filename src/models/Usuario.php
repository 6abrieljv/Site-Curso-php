<?php

class Usuario{
    private $id;
    private $nome_usuario;
    private $email;
    private $senha;
    private $dataCadastro;
    private $is_admin;
    private $ativo;

    public function __construct($id, $nome_usuario, $email, $senha, $dataCadastro, $is_admin=true, $ativo=true) {
        $this->id = $id;
        $this->nome_usuario = $nome_usuario;
        $this->email = $email;
        $this->senha = $senha;
        $this->dataCadastro = $dataCadastro;
        $this->is_admin = $is_admin;
        $this->ativo = $ativo;
    }
}