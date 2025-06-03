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
        if(empty($categoria->id)) {
            // Inserir nova categoria
            $sql = "INSERT INTO categoria (nome, cor, slug) VALUES (:nome, :cor, :slug)";
            $params = [
                'nome' => $categoria->nome,
                'cor' => $categoria->cor,
                'slug' => $categoria->slug
            ];
        } else {
            // Atualizar categoria existente
            $sql = "UPDATE categoria SET nome = :nome, cor = :cor, slug = :slug WHERE id = :id";
            $params = [
                'id' => $categoria->id,
                'nome' => $categoria->nome,
                'cor' => $categoria->cor,
                'slug' => $categoria->slug
            ];
        }
        $this->db->query($sql, $params, className: Categoria::class);
        if(empty($categoria->id)) {
            $categoria->id = $this->db->getConnection()->lastInsertId(); 
            // Pega o ID da nova categoria
    }
    return $categoria; // Retorna a categoria com o ID atualizado
    }

    public function delete($id)
    {
        $sql = "DELETE FROM categoria WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);
    }

    

}