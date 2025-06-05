<?php

class NoticiaRepository
{
    private $db;
    private $usuarioRepository;
    private $categoriaRepository;

    public function __construct()
    {
        $this->db = new Database();
        $this->usuarioRepository = new UsuarioRepository();
        $this->categoriaRepository = new CategoriaRepository();


    }

    public function findAll()

    {
        $sql = "SELECT * FROM noticia";
        $stmt = $this->db->query($sql);

        // Montando objeto
        foreach ($stmt as $row) {
            $noticia = new Noticia();
            $noticia->setId($row['id']);
            $noticia->setTitulo($row['titulo']);
            $noticia->setConteudo($row['conteudo']);
            $noticia->setDataPublicacao($row['data_publicacao']);
            $noticia->setUsuario($this->usuarioRepository->findById($row['usuario_id']));
            $noticia->setImagem($row['imagem']);
            $noticia->setCategoria($this->categoriaRepository->findById($row['categoria_id']));

            $result[] = $noticia;
        }

        return isset($result) ? $result : [];
    }
}
