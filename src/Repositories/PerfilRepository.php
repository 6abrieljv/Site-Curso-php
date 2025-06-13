<?php
namespace App\Repositories;

use App\Database\Database;
use App\Models\Perfil;
use PDO;

class PerfilRepository
{
    private $db;

    public function __construct()
    {
        $this->db = new Database('perfil');
    }

    public function findByUserId(int $userId)
    {
        $stmt = $this->db->select('id_usuario = :id_usuario', ['id_usuario' => $userId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? $this->mapToModel($data) : null;
    }

    public function save( $perfil)
    {
        $values = [
            'nome' => $perfil->getNome(),
            'sobrenome' => $perfil->getSobrenome(),
            'bio' => $perfil->getBio(),
            'foto' => $perfil->getFoto(),
            'github' => $perfil->getGithub(),
            'linkedin' => $perfil->getLinkedin(),
        ];

        $this->db->update($values, 'id_usuario = :id_usuario', ['id_usuario' => $perfil->getIdUsuario()]);
    }
    
    private function mapToModel( $data)
    {
        $perfil = new Perfil();
        $perfil->setId((int)$data['id']);
        $perfil->setIdUsuario((int)$data['id_usuario']);
        $perfil->setNome($data['nome']);
        $perfil->setSobrenome($data['sobrenome']);
        $perfil->setBio($data['bio']);
        $perfil->setFoto($data['foto']);
        $perfil->setGithub($data['github']);
        $perfil->setLinkedin($data['linkedin']);
        return $perfil;
    }
}