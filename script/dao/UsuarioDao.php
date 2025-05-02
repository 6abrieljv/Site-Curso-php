<?php 
date_default_timezone_set('America/Sao_Paulo'); 
class UsuarioDao  {
    
    private $conexao;
    private $usuario;

    public function __construct($conexao, $usuario) {
        $this->conexao = $conexao;
        $this->usuario = $usuario;
    }

    public function inserir( $perfil) {
        $query = "INSERT INTO usuario (nome, email, senha, data_cadastro)
                  VALUES (:nome, :email, :senha, :data_cadastro)";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':nome', $this->usuario->getNome());
        $stmt->bindValue(':email', $this->usuario->getEmail());
        $stmt->bindValue(':senha', password_hash($this->usuario->getSenha(), PASSWORD_DEFAULT));
        $stmt->bindValue(':data_cadastro', date('Y-m-d H:i:s')); // pega horário do servidor
    
        if ($stmt->execute()) {
            // Pega o ID do último usuário inserido
            $ultimoId = $this->conexao->lastInsertId();
    
            // Define esse ID no perfil
            $perfil->setIdUsuario($ultimoId);
    
            // Cadastra o perfil usando a classe PerfilDao
            $perfilDao = new PerfilDao($this->conexao, $perfil); // Passa o objeto PDO
    
            if ($perfilDao->cadastrar()) {
                return true;
            } else {
                $this->deleteUsuario($ultimoId); // Se falhar, deleta o usuário
                return false;
            }
        } else {
            return false;
        }
    }

    public function deleteUsuario($id) {
        $query = "DELETE FROM usuario WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id', $id);
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

    public function login($usuarioLogin) {
        $query = "SELECT * FROM usuario WHERE email = :email";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':email', $usuarioLogin->getEmail());
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se o usuário foi encontrado e se a senha está correta
        if ($resultado && password_verify($usuarioLogin->getSenha(), $resultado['senha'])) {
            return $resultado; // Retorna os dados do usuário
        } else {
            return false; // Login inválido
        }
    }
}
?>