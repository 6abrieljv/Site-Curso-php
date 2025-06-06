<?php

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

    public function findByUsername(string $email): ?Usuario
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

    public function login(string $email, string $senha): ?Usuario
    {
        
        // adidiconar logica de login

        return null;
    }

}