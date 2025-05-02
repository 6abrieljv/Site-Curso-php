<?php 

class Noticia {
    private $id;
    private $titulo;
    private $texto;
    private $data;
    private $imagem;
    private $idAutor;


    public function __construct( $titulo, $texto, $data, $imagem, $idAutor) {
        $this->titulo = $titulo;
        $this->texto = $texto;
        $this->data = $data;
        $this->imagem = $imagem;
        $this->idAutor = $idAutor;
    }
    public function getId() {
        return $this->id;
    }
    public function getTitulo() {
        return $this->titulo;
    }
    public function getTexto() {
        return $this->texto;
    }
    public function getData() {
        return $this->data;
    }
    public function getImagem() {
        return $this->imagem;
    }
    public function getIdAutor() {
        return $this->idAutor;
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }
    public function setTexto($texto) {
        $this->texto = $texto;
    }
    public function setData($data) {
        $this->data = $data;
    }
    public function setImagem($imagem) {
        $this->imagem = $imagem;
    }
    public function setIdAutor($idAutor) {
        $this->idAutor = $idAutor;
    }
}
    ?>