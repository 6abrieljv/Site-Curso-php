<?php
namespace App\Repositories;
use App\Models\Usuario;
use App\Database\Database;
use PDO;

class UsuarioRepository
{
    private $db;

    public function __construct()
    {
        $this->db = new Database("usuario");
    }

    public function findAll()
    {
        $stmt = $this->db->select();
    }
    public function findById(int $id)
    {
        $stmt = $this->db->select('id = :id', [':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        $usuario = new Usuario();
        $usuario->setId($data['id']);
        $usuario->setUsername($data['username']);
        $usuario->setEmail($data['email']);
        $usuario->setSenha($data['senha']);

        return $usuario;
    }


    public function cont($where = null)
    {
        $stmt = $this->db->select(fields: "COUNT(*) as total", where: $where);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return isset($result) ? $result['total'] : 0;
    }

}