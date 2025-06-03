<?php

class NoticiaRepository
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function findAll()

    {

        $sql = "SELECT n.id, n.usuario_id, n.titulo, n.slug, n.conteudo, n.imagem, n.data_publicacao, 
                u.username AS autor, c.nome AS categoria
                FROM noticia n
                JOIN usuario u ON n.usuario_id = u.id
                JOIN categoria c ON n.categoria_id= c.id";
        $stmt = $this->db->query($sql);
        var_dump($stmt->fetch());
        return $stmt->fetchAll();
    }
}
