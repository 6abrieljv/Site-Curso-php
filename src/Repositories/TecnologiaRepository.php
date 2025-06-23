<?php

namespace App\Repositories;

use App\Database\Database;
use App\Models\Tecnologia;
use PDO;

class TecnologiaRepository
{
    private $db;

    public function __construct()
    {
        $this->db = new Database('tecnologias');
    }

    /**
     * Busca todas as tecnologias cadastradas.
     * @return Tecnologia[]
     */
    public function findAll()
    {
        $stmt = $this->db->select(order: 'nome ASC');
        $techData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $tecnologias = [];

        foreach ($techData as $data) {
            $tech = new Tecnologia();
            $tech->setId($data['id']);
            $tech->setNome($data['nome']);
            $tech->setCor($data['cor']);
            $tech->setIcone($data['icone']);
            $tecnologias[] = $tech;
        }

        return $tecnologias;
    }

    // Futuramente, você adicionará aqui os métodos save(), delete(), etc.
}