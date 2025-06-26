<?php

namespace App\Repositories;

use App\Models\Usuario;
use App\Database\Database;
use PDO;

class UsuarioRepository
{
    private $db;
    private $perfilRepository;
    private $dbPerfil;

    public function __construct()
    {
        $this->db = new Database('usuario');
        $this->dbPerfil = new Database('perfil');
        $this->perfilRepository = new PerfilRepository();
    }

    /**
     * Cria um novo usuário e seu perfil correspondente.
     * @param Usuario $usuario
     * @return int O ID do novo usuário.
     */
    public function create(Usuario $usuario): int
    {
        // Inicia uma transação
        $this->db->execute('START TRANSACTION');

        try {
            // Insere o usuário
            $userId = $this->db->insert([
                'username' => $usuario->getUsername(),
                'email' => $usuario->getEmail(),
                'senha' => password_hash($usuario->getSenha(), PASSWORD_DEFAULT),
                'is_admin' => $usuario->isAdmin() ? 1 : 0
            ]);
            $perfil = new \App\Models\Perfil();
            $perfil->setIdUsuario($userId);

            // Cria um perfil padrão para o novo usuário
            
            // Confirma a transação
            $this->db->execute('COMMIT');
            $this->perfilRepository->save($perfil);

            return $userId;
        } catch (\Exception $e) {
            // Em caso de erro, desfaz tudo
            $this->db->execute('ROLLBACK');
            die('Erro ao criar usuário: ' . $e->getMessage());
        }
    }

    public function findAll($where = null): array
    {
        $stmt = $this->db->select(where: $where, order: 'username ASC');
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $usuarios = [];

        foreach ($data as $row) {
            $usuarios[] = $this->mapToModel($row);
            $usuarios[-1]->setPerfil($this->perfilRepository->findByUserId($usuarios[-1]->getId()));
        }

        return $usuarios;
    }

    /**
     * Encontra um usuário pelo e-mail.
     * @param string $email
     * @return Usuario|null
     */
    public function findByEmail(string $email): ?Usuario
    {
        $stmt = $this->db->select('email = :email', ['email' => $email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? $this->mapToModel($data) : null;
    }
    public function findById($id){
        $stmt = $this->db->select('id = :id', [':id' => $id]);
        $data = $stmt->fetch();
        if (!$data) {
            return null;
        }
        
        $usuario = new Usuario();
        $usuario->setId($data['id']);
        $usuario->setDataCadastro($data['data_cadastro']);
        $usuario->setEmail($data['email']);
        $usuario->setUsername($data['username']);

    }

    

    /**
     * Conta o total de usuários.
     * @return int
     */
    public function cont($where = null)
    {
        $stmt = $this->db->select(fields: "COUNT(*) as total", where: $where);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return isset($result) ? $result['total'] : 0;
    }

    /**
     * Mapeia dados do banco para um objeto Usuario.
     */
    private function mapToModel(array $data): Usuario
    {
        $usuario = new Usuario();
        $usuario->setId((int)$data['id']);
        $usuario->setUsername($data['username']);
        $usuario->setEmail($data['email']);
        $usuario->setSenha($data['senha']); // Senha já vem com hash do banco
        $data['is_admin'] ? $usuario->setIsAdmin(true) : $usuario->setIsAdmin(false);
        $usuario->setDataCadastro($data['data_cadastro']);
        return $usuario;
    }
}
