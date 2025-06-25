<?php
// src/Models/AtleticaMembro.php

namespace App\Models;

class AtleticaMembro
{
    private ?int $id = null;
    private ?string $nome = null;
    private ?string $cargo = null;
    private ?string $foto = null;
    private ?string $instagram_url = null;

    // --- Getters e Setters ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(?string $nome): void
    {
        $this->nome = $nome;
    }

    public function getCargo(): ?string
    {
        return $this->cargo;
    }

    public function setCargo(?string $cargo): void
    {
        $this->cargo = $cargo;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(?string $foto): void
    {
        $this->foto = $foto;
    }

    public function getInstagramUrl(): ?string
    {
        return $this->instagram_url;
    }

    public function setInstagramUrl(?string $instagram_url): void
    {
        $this->instagram_url = $instagram_url;
    }
}