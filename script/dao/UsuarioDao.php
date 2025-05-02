<?php 
class UsuarioDao  {
    
    private $conexao;
    private $usuario;

    public function __construct($conexao, $usuario) {
        $this->conexao = $conexao;
        $this->usuario = $usuario;
    }
    public function inserir() {
        $query = "INSERT INTO usuario (email, senha) VALUES ( :email, :senha)";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':email', $this->usuario->getEmail());
        $stmt->bindValue(':senha', password_hash($this->usuario->getSenha(), PASSWORD_DEFAULT));
        return $stmt->execute();
    }
    public function listar() {
        $query = "SELECT * FROM usuario";
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function buscarPorId($id) {
        $query = "SELECT * FROM usuario WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function login($usuario) {
        $query = "SELECT * FROM usuario WHERE email = :email";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':email', $usuario->getEmail());
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($resultado && password_verify($usuario->getSenha(), $resultado['senha'])) {
            return true;
        } else {
            return false;
        }
    }
    
}

?>