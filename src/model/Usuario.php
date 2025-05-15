<?php
date_default_timezone_set('America/Sao_Paulo'); // Define o fuso horário padrão para São Paulo

class Usuario
{
    private $id;
    private $nome;
    private $dataCriacao;
    private $email;
    private $senha;

    /**
     * Construtor da classe Usuario
     * @param string|null $nome Nome do usuário (opcional)
     * @param string $email Email do usuário
     * @param string $senha Senha do usuário
     */
    public function __construct($nome = null, $email, $senha)
    {
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = password_hash($senha, PASSWORD_DEFAULT); // Hash da senha
        $this->dataCriacao = date('Y-m-d H:i:s'); // Define a data de criação como o momento atual
    }

    // Métodos getters e setters
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
        $this->dataCriacao = date('Y-m-d H:i:s', strtotime($dataCriacao)); // Formata a data
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