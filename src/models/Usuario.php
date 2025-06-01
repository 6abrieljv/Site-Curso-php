<?php

class Usuario
{
    private $id;
    private $nome_usuario;
    private $email;
    private $senha;
    private $dataCadastro;
    private $is_admin;
    private $ativo;


    public function __toString()
    {
        return "Usuario [id={$this->id}, nome_usuario={$this->nome_usuario}, email={$this->email}, dataCadastro={$this->dataCadastro}, is_admin={$this->is_admin}, ativo={$this->ativo}]";
    }

    public function login()
    {
        // Implementar lógica de login, por exemplo, verificar email e senha no banco de dados
        // Retornar true se o login for bem-sucedido, caso contrário, false
        return true; // Placeholder para fins de exemplo
    }
    public function logout()
    {
        // Implementar lógica de logout, por exemplo, destruir a sessão
        session_destroy(); // Placeholder para fins de exemplo
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNomeUsuario()
    {
        return $this->nome_usuario;
    }

    public function setNomeUsuario($nome_usuario)
    {
        $this->nome_usuario = $nome_usuario;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    public function getDataCadastro()
    {
        return $this->dataCadastro;
    }

    public function setDataCadastro($dataCadastro)
    {
        $this->dataCadastro = $dataCadastro;
    }

    public function getIsAdmin()
    {
        return $this->is_admin;
    }

    public function setIsAdmin($is_admin)
    {
        $this->is_admin = $is_admin;
    }

    public function getAtivo()
    {
        return $this->ativo;
    }

    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
    }
}
