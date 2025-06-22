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
    private ?bool $is_educador;
    
    public function __construct(
        ?int $id = null,
        ?string $username = null,
        ?string $email = null,
        ?string $senha = null,
        ?string $data_cadastro = null,
        ?bool $is_admin = false,
        ?bool $is_educador = false
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        // Cuidado: password_hash(null, ...) vai gerar um aviso se $senha for null.
        // O ideal é que o hash da senha seja feito no Repository ao persistir no DB,
        // ou verificar se $senha não é null antes de fazer o hash aqui.
        $this->senha = ($senha !== null) ? password_hash($senha, PASSWORD_DEFAULT) : null;
        $this->data_cadastro = $data_cadastro;
        $this->is_admin = $is_admin;
        $this->is_educador = $is_educador;
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

    public function setIsAdmin( $is_admin)
    {
        $this->is_admin = $is_admin;
    }

    public function isEducador(): ?bool
    {
        return $this->is_educador;
    }

    public function setIsEducador(?bool $is_educador): void
    {
        $this->is_educador = $is_educador; // <-- Linha corrigida aqui
    }
}