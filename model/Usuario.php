<?php 

class Usuario
{
    private $id;
    private $nome;
    private $dataCriacao ;
    private $email;
    private $senha;


    public function __construct($nome, $email, $senha)
    {
        $this->nome = $nome;
      
        $this->email = $email;
        $this->senha = password_hash($senha, PASSWORD_DEFAULT); // Hashing the password
    }
    public function __construct2( $email, $senha)
    {
        
        $this->email = $email;
        $this->senha = password_hash($senha, PASSWORD_DEFAULT); // Hashing the password
        
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getDataCriacao()
    {
        return $this->dataCriacao;
    }
    public function setDataCriacao($dataCriacao)
    {
        $this->dataCriacao = $dataCriacao;
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
}