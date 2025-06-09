<?php
namespace App\Repositories;
use App\Utils\Database;
use App\Models\Noticia;
use App\Repositories\UsuarioRepository;
use App\Repositories\CategoriaRepository;
use PDO;
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
    
     public function count(): int
    {
        $sql = "SELECT COUNT(*) as total FROM noticia";
        $stmt = $this->db->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$row['total'];
    }
}
