<?php 

class Perfil {  
    private $id;
    private $nome;
    private $periodo;
    private $idade; 
    private $bio;
    private $imagem;

    private $idUsuario;
    

    public function __construct($nome, $periodo, $idade, $bio, $imagem , $idUsuario) {
        $this->nome = $nome;
        $this->periodo = $periodo;
        $this->idade = $idade;
        $this->bio = $bio;
        $this->imagem = $imagem;
        $this->idUsuario = $idUsuario;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNome() {
        return $this->nome;
    }
    public function setNome($nome) {
        $this->nome = $nome;
    }
    public function getPeriodo() {
        return $this->periodo;
    }
    public function setPeriodo($periodo) {
        $this->periodo = $periodo;
    }    
    public function getIdade() {
        return $this->idade;
    }
    public function setIdade($idade) {
        $this->idade = $idade;
    }
    public function getBio() {
        return $this->bio;
    }
    public function setBio($bio) {
        $this->bio = $bio;
    }
    public function getImagem() {
        return $this->imagem;
    }
    public function setImagem($imagem) {
        $this->imagem = $imagem;
    }
    public function getIdUsuario() {
        return $this->idUsuario;
    }    
    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }
    
}
    ?>