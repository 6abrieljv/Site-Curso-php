<?php

class CategoriaRepository{
    private $db;
    
    public function __construct()
    {
        $this->db = new Database();
    }

    // metodo para buscar todas as categorias
    public function findAll()
    {
        $sql = "SELECT * FROM categoria";
        return $this->db->query($sql, [], Categoria::class)->fetchAll();
    }

    public function findById($id)
    {

        $sql = "SELECT * FROM categoria WHERE id = :id";
        $stmt = $this->db->query($sql, ['id' => $id], Categoria::class);
        if ($stmt->rowCount() === 0) {
            return null; // Retorna null se não encontrar a categoria
        }
        return $stmt->fetch();
    }

    // metodo para fazer update ou criar uma categoria
    public function save(Categoria $categoria)
    {
        if(empty($categoria->getId())) {
            // Inserir nova categoria
            $sql = "INSERT INTO categoria (nome, cor, slug) VALUES (:nome, :cor, :slug)";
            $params = [
                'nome' => $categoria->getNome(),
                'cor' => $categoria->getCor(),
                'slug' => $categoria->getSlug()
            ];
        } else {
            // Atualizar categoria existente
            $sql = "UPDATE categoria SET nome = :nome, cor = :cor, slug = :slug WHERE id = :id";
            $params = [
                'id' => $categoria->getId(),
                'nome' => $categoria->getNome(),
                'cor' => $categoria->getCor(),
                'slug' => $categoria->getSlug()
            ];
        }
        $this->db->query($sql, $params, className: Categoria::class);
        if(empty($categoria->getId())) {
            $categoria->setId($this->db->getConnection()->lastInsertId()); 
            // Pega o ID da nova categoria
    }
    return $categoria; // Retorna a categoria com o ID atualizado
    }

    public function delete($id)
    {
        $sql = "DELETE FROM categoria WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);
    }

     public function count(): int
    {
        $sql = "SELECT COUNT(*) as total FROM categoria";
        $stmt = $this->db->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$row['total'];
    }
    

}