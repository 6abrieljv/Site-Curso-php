<?php

namespace App\Models;

class Tecnologia
{
    private ?int $id = null;
    private ?string $nome = null;
    private ?string $cor = null;
    private ?string $icone = null;

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

    public function getCor(): ?string
    {
        return $this->cor;
    }

    public function setCor(?string $cor): void
    {
        $this->cor = $cor;
    }

    public function getIcone(): ?string
    {
        return $this->icone;
    }

    public function setIcone(?string $icone): void
    {
        $this->icone = $icone;
    }
}