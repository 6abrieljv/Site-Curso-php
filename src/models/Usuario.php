<?php

class Usuario{
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $dataCadastro;

    public function __construct($nome, $email, $senha, $id = null)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = password_hash($senha, PASSWORD_DEFAULT);
        $this->dataCadastro = date('Y-m-d', strtotime('now'));
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getDataCadastro() {
        return $this->dataCadastro;
    }
}