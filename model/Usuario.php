<?php 

class Usuario
{
    private $id;
    private $email;
    private $senha;


    public function __construct($email, $senha)
    {
        $this->email = $email;
        $this->senha = $senha;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getSenha()
    {
        return $this->senha;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }
    public function __toString()
    {
        return "ID: " . $this->id . ", Email: " . $this->email . ", Senha: " . $this->senha;
    }   
    
   
}   
?>