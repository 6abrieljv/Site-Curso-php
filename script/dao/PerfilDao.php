<?php 

class PerfilDao {
    private $conexao;
    private $perfil;

    public function __construct(PDO $conexao, Perfil $perfil) { // Aceitar um objeto PDO
        $this->conexao = $conexao;
        $this->perfil = $perfil;
    }

    public function cadastrar() {
        $query = "INSERT INTO perfil (id_usuario, bio, foto) VALUES (:id_usuario, :bio, :foto)";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id_usuario', $this->perfil->getIdUsuario());
        $stmt->bindValue(':bio', $this->perfil->getBio());
        $stmt->bindValue(':foto', $this->perfil->getFoto());
        return $stmt->execute();
    }

    public function listar() {
        $query = "SELECT * FROM perfil";
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id) {
        $query = "SELECT * FROM perfil WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar() {
        $query = "UPDATE perfil SET bio = :bio, imagem = :imagem WHERE id_usuario = :id_usuario";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':bio', $this->perfil->getBio());
        $stmt->bindValue(':imagem', $this->perfil->getImagem());
        $stmt->bindValue(':id_usuario', $this->perfil->getIdUsuario());
        return $stmt->execute();
    }

    public function deletar($id) {
        $query = "DELETE FROM perfil WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}

?>