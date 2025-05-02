<?php 

class Noticia {
    private $id;
    private $titulo;
    private $conteudo;
    private $dataPublicacao;
    private $imagem;
    private $idAutor;

    /**
     * Construtor da classe Noticia
     * @param string $titulo Título da notícia
     * @param string $texto Texto da notícia
     * @param string|null $dataPublicacao Data de publicação (opcional, usa a data atual se não fornecida)
     * @param string $imagem Caminho da imagem
     * @param int $idAutor ID do autor da notícia
     */
    public function __construct($titulo, $conteudo, $dataPublicacao = null, $imagem, $idAutor) {
        $this->titulo = $titulo;
        $this->conteudo = $conteudo;
        $this->dataPublicacao = $dataPublicacao ?? date('Y-m-d H:i:s'); // Usa a data atual se não fornecida
        $this->imagem = $imagem;
        $this->idAutor = $idAutor;
    }

    // Métodos getters e setters
    public function getId() {
        return $this->id;
    }   
    public function setId($id) {
        $this->id = $id;
    }

    public function getTitulo() {
        return $this->titulo;
    }
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function getConteudo() {
        return $this->conteudo;
    }   
    public function setConteudo($conteudo) {
        $this->conteudo = $conteudo;
    }

    public function getDataPublicacao() {
        return $this->dataPublicacao;
    }
    public function setDataPublicacao($dataPublicacao) {
        $this->dataPublicacao = date('Y-m-d H:i:s', strtotime($dataPublicacao)); // Formata a data
    }

    public function getImagem() {
        return $this->imagem;
    }
    public function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    public function getIdAutor() {
        return $this->idAutor;
    }
    public function setIdAutor($idAutor) {
        $this->idAutor = $idAutor;
    }
}
?>