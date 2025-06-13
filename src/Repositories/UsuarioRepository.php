<?php

namespace App\Repositories;

use App\Models\Usuario;
use App\Database\Database;
use PDO;

class UsuarioRepository
{
    private $db;
    private $dbPerfil;

    public function __construct()
    {
        $this->db = new Database('usuario');
        $this->dbPerfil = new Database('perfil');
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

            // Cria um perfil padrão para o novo usuário
            $this->dbPerfil->insert([
                'id_usuario' => $userId,
                'nome' => $usuario->getUsername(), // Usa o username como nome padrão
                'sobrenome' => '',
                'bio' => 'Bem-vindo ao NerdHub!'
            ]);

            // Confirma a transação
            $this->db->execute('COMMIT');

            return $userId;
        } catch (\Exception $e) {
            // Em caso de erro, desfaz tudo
            $this->db->execute('ROLLBACK');
            die('Erro ao criar usuário: ' . $e->getMessage());
        }
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

    /**
     * Conta o total de usuários.
     * @return int
     */
    public function count(): int
    {
        return $this->db->select(null, [], null, null, 'COUNT(*) as total')
            ->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
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
