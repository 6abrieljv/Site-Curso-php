<?php
namespace App\Models;

use App\Utils\StringUtils;
class Categoria
{
    private ?int $id;
    private ?string $nome;
    private ?string $cor;
    private ?string $slug;

    public function __construct(
        ?int $id = null,
        ?string $nome = null,
        ?string $cor = null,
        ?string $slug = null
    ) {
        $this->id = $id;
        $this->nome = $nome;
        $this->cor = $cor;
        $this->slug = $nome !== null ? StringUtils::slugify($nome) : null;
    }
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
        $this->slug = StringUtils::slugify($nome);
    }

    public function getCor(): ?string
    {
        return $this->cor;
    }

    public function setCor(?string $cor): void
    {
        $this->cor = $cor;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }
}
