<?php 
class ProjetoDao {
    private $conexao;
    
    public function __construct(PDO $conexa , Projeto $projeto) {
        $this->conexao = $conexao;
        $this->projeto = $projeto;
    }
    
    public function cadastrar() {
        $query = "INSERT INTO projeto (nome, descricao, time) VALUES (:nome, :descricao, :time)";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':nome', $this->projeto->getNome());
        $stmt->bindValue(':descricao', $this->projeto->getDescricao());
        $stmt->bindValue(':time', $this->projeto->getTime());
        $stmt->execute();
    }
    
    public function listar() {
        $query = "SELECT * FROM projeto";
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function buscarPorId($id) {
        $query = "SELECT * FROM projeto WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deletar($id) {
        $query = "DELETE FROM projeto WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }


    
    
    
}
?>