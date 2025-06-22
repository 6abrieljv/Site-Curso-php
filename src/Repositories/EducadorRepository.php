<?php

namespace App\Repositories;

use App\Database\Database;
use App\Models\Usuario;
use App\Models\Perfil;
use PDO;

class EducadorRepository
{
    private $dbUsuario;
    private $dbPerfil;

    public function __construct()
    {
        $this->dbUsuario = new Database('usuario');
        $this->dbPerfil = new Database('perfil');
    }

    /**
     * Cria um novo educador (usuário e perfil).
     * @param Usuario $usuario
     * @param Perfil $perfil
     * @return int O ID do novo usuário/educador.
     * @throws \Exception
     */
    public function create(Usuario $usuario, Perfil $perfil): int
    {
        $this->dbUsuario->execute('START TRANSACTION');

        try {
            // Insere o usuário como educador
            $userId = $this->dbUsuario->insert([
                'username' => $usuario->getUsername(),
                'email' => $usuario->getEmail(),
                'senha' => password_hash($usuario->getSenha(), PASSWORD_DEFAULT), // Faz o hash da senha aqui
                'is_admin' => $usuario->isAdmin() ? 1 : 0,
                'is_educador' => 1 // Define como educador
            ]);

            // Cria o perfil correspondente
            $perfil->setIdUsuario($userId); // Associa o ID do usuário ao perfil
            $this->dbPerfil->insert([
                'id_usuario' => $perfil->getIdUsuario(),
                'nome' => $perfil->getNome(),
                'sobrenome' => $perfil->getSobrenome(),
                'bio' => $perfil->getBio(),
                'cargo' => $perfil->getCargo(), // Salva o cargo
                'foto' => $perfil->getFoto(),
                'github' => $perfil->getGithub(),
                'linkedin' => $perfil->getLinkedin(),
                // Adicione outros campos do perfil se houver
            ]);

            $this->dbUsuario->execute('COMMIT');
            return $userId;

        } catch (\Exception $e) {
            $this->dbUsuario->execute('ROLLBACK');
            throw new \Exception("Erro ao criar educador: " . $e->getMessage());
        }
    }

    /**
     * Atualiza um educador (usuário e perfil).
     * @param Usuario $usuario
     * @param Perfil $perfil
     * @throws \Exception
     */
    public function update(Usuario $usuario, Perfil $perfil): void
    {
        $this->dbUsuario->execute('START TRANSACTION');

        try {
            // Prepara os valores para atualização do usuário.
            $userUpdateValues = [
                'username' => $usuario->getUsername(),
                'email' => $usuario->getEmail(),
                'is_admin' => $usuario->isAdmin() ? 1 : 0,
                'is_educador' => $usuario->isEducador() ? 1 : 0
            ];

            // A senha só é atualizada se um novo valor (não nulo/vazio) for fornecido.
            // O hash deve ser feito ANTES de chamar este método, ou já ser um hash.
            if ($usuario->getSenha() !== null && !empty($usuario->getSenha())) {
                 // Se a senha vem sem hash do formulário, faça o hash aqui.
                 // Se já vem com hash (ex: de um findById), não faça de novo.
                 // No contexto do AdminEducadoresController, a senha vira string vazia se não alterada,
                 // então a lógica abaixo é mais robusta.
                if (strpos($usuario->getSenha(), '$2y$') !== 0) { // Verifica se não é um hash bcrypt
                     $userUpdateValues['senha'] = password_hash($usuario->getSenha(), PASSWORD_DEFAULT);
                } else {
                     $userUpdateValues['senha'] = $usuario->getSenha(); // Já é um hash
                }
            }

            $this->dbUsuario->update($userUpdateValues, 'id = :id', ['id' => $usuario->getId()]);

            // Atualiza o perfil correspondente
            $this->dbPerfil->update([
                'nome' => $perfil->getNome(),
                'sobrenome' => $perfil->getSobrenome(),
                'bio' => $perfil->getBio(),
                'cargo' => $perfil->getCargo(),
                'foto' => $perfil->getFoto(),
                'github' => $perfil->getGithub(),
                'linkedin' => $perfil->getLinkedin(),
            ], 'id_usuario = :id_usuario', ['id_usuario' => $usuario->getId()]);

            $this->dbUsuario->execute('COMMIT');

        } catch (\Exception $e) {
            $this->dbUsuario->execute('ROLLBACK');
            throw new \Exception("Erro ao atualizar educador: " . $e->getMessage());
        }
    }

    /**
     * Deleta um educador pelo ID de usuário.
     * @param int $userId
     * @return void
     * @throws \Exception
     */
    public function delete(int $userId): void
    {
        $this->dbUsuario->execute('START TRANSACTION');
        try {
            // O ON DELETE CASCADE deve lidar com o perfil
            $this->dbUsuario->delete('id = :id', ['id' => $userId]);
            $this->dbUsuario->execute('COMMIT');
        } catch (\Exception $e) {
            $this->dbUsuario->execute('ROLLBACK');
            throw new \Exception("Erro ao deletar educador: " . $e->getMessage());
        }
    }

    /**
     * Encontra um educador (usuário e perfil) pelo ID do usuário.
     * @param int $userId
     * @return array|null Retorna um array associativo com Usuario e Perfil, ou null.
     */
    public function findById(int $userId): ?array
    {
        $query = "SELECT u.id as usuario_id, u.username, u.email, u.data_cadastro, u.is_admin, u.is_educador, u.senha,
                         p.id as perfil_id, p.nome as perfil_nome, p.sobrenome, p.bio, p.foto, p.cargo, p.github, p.linkedin
                  FROM usuario u
                  LEFT JOIN perfil p ON u.id = p.id_usuario
                  WHERE u.id = :id AND u.is_educador = 1"; // Busca apenas educadores
        $stmt = $this->dbUsuario->execute($query, ['id' => $userId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return $this->mapToModel($data);
    }

    /**
     * Lista todos os educadores com suporte a paginação e busca.
     * @param string|null $order
     * @param string|null $limit
     * @param string|null $search
     * @return array Retorna um array de arrays, cada um com um objeto Usuario e um objeto Perfil.
     */
    public function findAll(?string $order = null, ?string $limit = null, ?string $search = null): array
    {
        $where = 'u.is_educador = 1';
        $params = [];

        if ($search) {
            // Busca em username, nome do perfil, sobrenome, bio e cargo
            $where .= ' AND (u.username LIKE :search OR p.nome LIKE :search OR p.sobrenome LIKE :search OR p.bio LIKE :search OR p.cargo LIKE :search)';
            $params['search'] = '%' . $search . '%';
        }

        $query = "SELECT u.id as usuario_id, u.username, u.email, u.data_cadastro, u.is_admin, u.is_educador, u.senha,
                         p.id as perfil_id, p.nome as perfil_nome, p.sobrenome, p.bio, p.foto, p.cargo, p.github, p.linkedin
                  FROM usuario u
                  LEFT JOIN perfil p ON u.id = p.id_usuario
                  WHERE {$where} " .
                  ($order ? "ORDER BY {$order}" : "") . " " .
                  ($limit ? "LIMIT {$limit}" : "");

        $stmt = $this->dbUsuario->execute($query, $params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $educadores = [];
        foreach ($results as $row) {
            $educadores[] = $this->mapToModel($row);
        }
        return $educadores;
    }

    /**
     * Conta o total de educadores.
     * @param string|null $search
     * @return int
     */
    public function count(?string $search = null): int
    {
        $where = 'u.is_educador = 1';
        $params = [];

        if ($search) {
            $where .= ' AND (u.username LIKE :search OR p.nome LIKE :search OR p.sobrenome LIKE :search OR p.bio LIKE :search OR p.cargo LIKE :search)';
            $params['search'] = '%' . $search . '%';
        }

        $query = "SELECT COUNT(u.id) as total
                  FROM usuario u
                  LEFT JOIN perfil p ON u.id = p.id_usuario
                  WHERE {$where}";
        $stmt = $this->dbUsuario->execute($query, $params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    /**
     * Mapeia os dados do banco para objetos Usuario e Perfil.
     * @param array $data
     * @return array Contém 'usuario' => Usuario e 'perfil' => Perfil
     */
    private function mapToModel(array $data): array
    {
        $usuario = new Usuario();
        $usuario->setId((int)$data['usuario_id']);
        $usuario->setUsername($data['username']);
        $usuario->setEmail($data['email']);
        $usuario->setSenha($data['senha']); // Necessário para reter o hash existente se não for atualizada
        $usuario->setIsAdmin((bool)$data['is_admin']);
        $usuario->setIsEducador((bool)$data['is_educador']);
        $usuario->setDataCadastro($data['data_cadastro']);


        $perfil = new Perfil();
        $perfil->setId((int)$data['perfil_id']);
        $perfil->setIdUsuario((int)$data['usuario_id']);
        $perfil->setNome($data['perfil_nome']);
        $perfil->setSobrenome($data['sobrenome']);
        $perfil->setBio($data['bio']);
        $perfil->setFoto($data['foto']);
        $perfil->setCargo($data['cargo']);
        $perfil->setGithub($data['github']);
        $perfil->setLinkedin($data['linkedin']);

        return [
            'usuario' => $usuario,
            'perfil' => $perfil
        ];
    }
}