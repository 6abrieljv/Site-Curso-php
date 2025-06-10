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
        $this->nome = $nome; // Define o nome primeiro
        $this->cor = $cor;

        // Se um slug for fornecido explicitamente (ex: do banco de dados), use-o.
        // Caso contrário, gere a partir do nome, se o nome existir.
        if ($slug !== null) {
            $this->slug = $slug;
        } elseif ($this->nome !== null) {
            $this->slug = StringUtils::slugify($this->nome);
        } else {
            $this->slug = null;
        }
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
        // Atualiza o slug com base no novo nome.
        // Se o nome for null, o slug também deve ser null.
        if ($this->nome !== null) {
            $this->slug = StringUtils::slugify($this->nome);
        } else {
            $this->slug = null;
        }
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
