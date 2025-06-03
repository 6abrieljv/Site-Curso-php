<?php 
class Projeto_Ltd {
    private $id;
    private $nome;
    private $descricao;
    private $Time;

    public function __construct($nome, $descricao, $Time) {
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->Time = $Time;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getNome() {
        return $this->nome;
    }
    
    public function getDescricao() {
        return $this->descricao;
    }
    
    public function getTime() {
        return $this->Time;
    }
}
?>