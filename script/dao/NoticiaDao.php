<?php 
class NoticiaDao {
    private $conexao;
    private $noticia;

    public function __construct(PDO $conexao, Noticia $noticia) { // Aceitar um objeto PDO
        $this->conexao = $conexao;
        $this->noticia = $noticia;
    }

    public function cadastrar() {
        $query = "INSERT INTO noticia (titulo, conteudo, data_publicacao, imagem, usuario_id) 
                  VALUES (:titulo, :conteudo, :data_publicacao, :imagem, :usuario_id)";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':titulo', $this->noticia->getTitulo());
        $stmt->bindValue(':conteudo', $this->noticia->getConteudo());
        $stmt->bindValue(':data_publicacao', $this->noticia->getDataPublicacao());
        $stmt->bindValue(':imagem', $this->noticia->getImagem());
        $stmt->bindValue(':usuario_id', $this->noticia->getIdAutor()); // Alinhado com a tabela
        return $stmt->execute();
    }

    public function listar() {
        $query = "SELECT * FROM noticia";
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id) {
        $query = "SELECT * FROM noticia WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar() {
        $query = "UPDATE noticia 
                  SET titulo = :titulo, conteudo = :conteudo, data_publicacao = :data_publicacao, imagem = :imagem 
                  WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':titulo', $this->noticia->getTitulo());
        $stmt->bindValue(':conteudo', $this->noticia->getConteudo());
        $stmt->bindValue(':data_publicacao', $this->noticia->getDataPublicacao());
        $stmt->bindValue(':imagem', $this->noticia->getImagem());
        $stmt->bindValue(':id', $this->noticia->getId());
        return $stmt->execute();
    }

    public function deletar($id) {
        $query = "DELETE FROM noticia WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}
?>