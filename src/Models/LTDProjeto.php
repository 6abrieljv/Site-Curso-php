<?php
namespace App\Models;
class LTDProjeto
{

    private ?int $id = null;
    private ?string $nome = null;
    private ?string $descricao = null;
    private ?string $status = null;
    private ?string $periodo = null;
    private ?string $created_at = null;
    
    // Novas propriedades para imagem e link do GitHub
    private ?string $imagem = null;
    private ?string $github = null;

    // Propriedades para guardar os arrays de objetos relacionados
    private array $tecnologias = [];
    private array $participantes = [];


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

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }
    public function setDescricao(?string $descricao): void
    {
        $this->descricao = $descricao;
    }
    public function getStatus(): ?string
    {
        return $this->status;
    }
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }
    public function getPeriodo(): ?string
    {
        return $this->periodo;
    }
    public function setPeriodo(?string $periodo): void
    {
        $this->periodo = $periodo;
    }
    public function getCreated_at(): ?string
    {
        return $this->created_at;
    }
    public function setCreated_at(?string $created_at): void
    {
        $this->created_at = $created_at;
    }
    public function getImagem(): ?string
    {
        return $this->imagem;
    }
    public function setImagem(?string $imagem): void
    {
        $this->imagem = $imagem;
    }
    public function getGithub(): ?string
    {
        return $this->github;
    }
    public function setGithub(?string $github): void
    {
        $this->github = $github;
    }
    public function getTecnologias(): array
    {
        return $this->tecnologias;
    }
    public function setTecnologias(array $tecnologias): void
    {
        $this->tecnologias = $tecnologias;  
    }
    public function getParticipantes(): array
    {
        return $this->participantes;
    }
    public function setParticipantes(array $participantes): void
    {
        $this->participantes = $participantes;
    }
    public function addTecnologia($tecnologia): void
    {
        $this->tecnologias[] = $tecnologia;
    }
    public function addParticipante($participante): void
    {
        $this->participantes[] = $participante;
    }

}
