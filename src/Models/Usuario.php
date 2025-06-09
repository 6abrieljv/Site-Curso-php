<?php
namespace App\Models;

class Usuario
{
    private ?int $id;
    private ?string $username;
    private ?string $email;
    private ?string $senha;

    private $data_cadastro;
    private $is_admin;
    
    public function __construct(
        ?int $id = null,
        ?string $username = null,
        ?string $email = null,
        ?string $senha = null,
        ?string $data_cadastro = null,
        ?bool $is_admin = false
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->senha = password_hash($senha, PASSWORD_DEFAULT);
        $this->data_cadastro = $data_cadastro;
        $this->is_admin = $is_admin;
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(?int $id): void
    {
        $this->id = $id;
    }
    public function getUsername(): ?string
    {
        return $this->username;
    }
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
    public function getSenha(): ?string
    {
        return $this->senha;
    }
    public function setSenha(?string $senha): void
    {
        $this->senha = $senha;
    }
    public function getDataCadastro(): ?string
    {
        return $this->data_cadastro;
    }
    public function setDataCadastro(?string $data_cadastro): void
    {
        $this->data_cadastro = $data_cadastro;

    }

    public function isAdmin(): ?bool
    {
        return $this->is_admin;
    }

    
}
