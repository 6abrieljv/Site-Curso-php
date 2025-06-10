<?php
namespace App\Repositories;
use App\Models\Categoria;
use App\Database\Database;

use PDO;

class CategoriaRepository{
    private $db;
    
    public function __construct()
    {
        $this->db = new Database('categoria');
    }

    public function save(Categoria $categoria)
    {
        $values = [
            'nome' => $categoria->getNome(),
            'cor' => $categoria->getCor(),
            'slug' => $categoria->getSlug()
        ];
        if (empty($categoria->getId())) {
            $id = $this->db->insert($values);
            $categoria->setId($id);
        } else {
            // Atualizar
            $this->db->update($values, 'id = :id', ['id' => $categoria->getId()]);
        }
        return $categoria;
    }

    public function delete(int $id)
    {
        $this->db->delete('id = :id', ['id' => $id]);
    }

    public function findAll()
    {
        $stmt = $this->db->select();
        foreach ($stmt as $row) {
            $categoria = new Categoria();
            $categoria->setId($row['id']);
            $categoria->setNome($row['nome']);
            $categoria->setCor($row['cor']);
            $categoria->setSlug($row['slug']);

            $result[] = $categoria;
        }

        return isset($result) ? $result : [];
    }

    public function findById(int $id)
    {
        $stmt = $this->db->select('id = :id', [':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        $categoria = new Categoria();
        $categoria->setId($data['id']);
        $categoria->setNome($data['nome']);
        $categoria->setCor($data['cor']);
        $categoria->setSlug($data['slug']);

        return $categoria;

    }

}
