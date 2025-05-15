<?php 

class Conexao {
    private $host = "localhost";
    private $user = "postgres";
    private $pass = "2004";
    private $banco = "curso_site";

    public function conectar() {
        try {
            $conexao = new PDO("pgsql:host={$this->host};dbname={$this->banco}", $this->user, $this->pass);
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexao;
        } catch (PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
            return false;
        }
    }
}

?>