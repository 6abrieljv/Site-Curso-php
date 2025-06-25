<?php
// src/Repositories/AtleticaRepository.php

namespace App\Repositories;

use App\Database\Database;
use App\Models\AtleticaMembro;
use PDO;

class AtleticaRepository
{
    private $db;

    public function __construct()
    {
        $this->db = new Database('atletica_membros');
    }

    public function save(AtleticaMembro $membro): void
    {
        $values = [
            'nome' => $membro->getNome(),
            'cargo' => $membro->getCargo(),
            'foto' => $membro->getFoto(),
            'instagram_url' => $membro->getInstagramUrl()
        ];

        if ($membro->getId()) {
            // Atualizar
            $this->db->update($values, 'id = :id', ['id' => $membro->getId()]);
        } else {
            // Inserir
            $this->db->insert($values);
        }
    }

    public function findById(int $id): ?AtleticaMembro
    {
        $stmt = $this->db->select('id = :id', ['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->mapToModel($data) : null;
    }
    
    public function findAll(string $order = 'id DESC', ?string $limit = null): array
    {
        $stmt = $this->db->select(null, [], $order, $limit);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $membros = [];
        foreach ($results as $row) {
            $membros[] = $this->mapToModel($row);
        }
        return $membros;
    }

    public function delete(int $id): void
    {
        $this->db->delete('id = :id', ['id' => $id]);
    }

    public function count(): int
    {
        return $this->db->select(null, [], null, null, 'COUNT(*) as total')
            ->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    }

    private function mapToModel(array $data): AtleticaMembro
    {
        $membro = new AtleticaMembro();
        $membro->setId((int)$data['id']);
        $membro->setNome($data['nome']);
        $membro->setCargo($data['cargo']);
        $membro->setFoto($data['foto']);
        $membro->setInstagramUrl($data['instagram_url']);
        return $membro;
    }
}