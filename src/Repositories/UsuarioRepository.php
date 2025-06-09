<?php
namespace App\Repositories;
use App\Models\Usuario;
use App\Utils\Database;
use PDO;

class UsuarioRepository
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function findAll()
    {
        $sql = "SELECT * FROM usuario";
        $stmt = $this->db->query($sql);

        // Montando objeto
        foreach ($stmt as $row) {
            $usuario = new Usuario();
            $usuario->setId($row['id']);
            $usuario->setUsername($row['username']);
            $usuario->setEmail($row['email']);
            $usuario->setSenha($row['senha']);
            $usuario->setDataCadastro($row['data_cadastro']);

            $result[] = $usuario;
        }

        return isset($result) ? $result : [];
    }

    public function findById(int $id): ?Usuario
    {
        $sql = "SELECT * FROM usuario WHERE id = :id";
        $stmt = $this->db->query($sql, ['id' => $id]);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $usuario = new Usuario();
            $usuario->setId($row['id']);
            $usuario->setUsername($row['username']);
            $usuario->setEmail($row['email']);
            $usuario->setSenha($row['senha']);
            $usuario->setDataCadastro($row['data_cadastro']);

            return $usuario;
        }
        return null;
    }

    public function findByEmail(string $email): ?Usuario
    {
        $sql = "SELECT * FROM usuario WHERE email = :email";
        $stmt = $this->db->query($sql, ['email' => $email]);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $usuario = new Usuario();
            $usuario->setId($row['id']);
            $usuario->setUsername($row['username']);
            $usuario->setEmail($row['email']);
            $usuario->setSenha($row['senha']);
            $usuario->setDataCadastro($row['data_cadastro']);

            return $usuario;
        }
        return null;
    }

    public function count(): int
    {
        $sql = "SELECT COUNT(*) as total FROM usuario";
        $stmt = $this->db->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$row['total'];
    }

}