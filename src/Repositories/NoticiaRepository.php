<?php

namespace App\Repositories;

use App\Database\Database;
use App\Models\Noticia;
use App\Models\Usuario;
use App\Models\Categoria;
use App\Repositories\CategoriaRepository;
use PDO;

class NoticiaRepository
{
    private $db;
    private $categoriaRepository;


    public function __construct()
    {
        // Utiliza a classe de banco de dados para a tabela 'noticia'
        $this->db = new Database('noticia');
        $this->categoriaRepository = new CategoriaRepository();
    }

    /**
     * Salva (cria ou atualiza) uma notícia.
     * @param Noticia $noticia
     * @return Noticia
     */
    public function save(Noticia $noticia)
    {
        $values = [
            'titulo' => $noticia->getTitulo(),
            'conteudo' => $noticia->getConteudo(),
            'slug' => $noticia->getSlug(),
            'usuario_id' => $noticia->getIdUsuario(),
            'categoria_id' => $noticia->getIdCategoria(),
            // A imagem pode ser tratada separadamente ou aqui
            'imagem' => $noticia->getImagem(),
        ];

        if (empty($noticia->getId())) {
            // Inserir
            $values['data_publicacao'] = date('Y-m-d H:i:s');
            $id = $this->db->insert($values);
            $noticia->setId($id);
        } else {
            // Atualizar
            $this->db->update($values, 'id = :id', ['id' => $noticia->getId()]);
        }
        return $noticia;
    }

    /**
     * Deleta uma notícia pelo ID.
     * @param int $id
     * @return bool
     */
    public function delete(int $id)
    {
        $this->db->delete('id = :id', ['id' => $id]);
    }


    public function findById($id)
    {
        $stmt = $this->db->select('id = :id', [':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return $this->mapToModel($data);
    }

    /**
     * Encontra todas as notícias.
     * @return Noticia[]
     */
    public function findAll($order = null)
    {
        // Query para buscar notícias com nome do autor e da categoria
        $stmt = $this->db->select(order: $order);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row) {
            $noticia = $this->mapToModel($row);

            if (!empty($row["usuario_id"])) {
                // adicionar logica de adicionar usuario
            }
            if (!empty($row["categoria_id"])) {
                $categoria = $this->categoriaRepository->findById($row["categoria_id"]);
                $noticia->setCategoria($categoria);
                
            }
            $noticias[] = $noticia;
        }

        return isset($noticias) ? $noticias : [];
    }

    /**
     * Conta o total de notícias.
     * @return int
     */
    public function count(): int
    {
        return $this->db->select(null, null, null, 'COUNT(*) as total')
            ->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    }

    /**
     * Mapeia um array de dados para o objeto Noticia.
     * @param array $data
     * @return Noticia
     */
    private function mapToModel(array $data): Noticia
    {
        $noticia = new Noticia();
        $noticia->setId($data['id']);
        $noticia->setTitulo($data['titulo']);
        $noticia->setConteudo($data['conteudo']);
        $noticia->setSlug($data['slug']);
        $noticia->setImagem($data['imagem']);
        $noticia->setDataPublicacao($data['data_publicacao']);
        $noticia->setIdUsuario($data['usuario_id']);
        $noticia->setIdCategoria($data['categoria_id']);

        // Adiciona dados do autor e categoria se existirem no join
        if (isset($data['autor_nome'])) {
            $autor = new Usuario();
            $autor->setUsername($data['autor_nome']);
            $noticia->setUsuario($autor);
        }

        if (isset($data['categoria_nome'])) {
            $categoria = $this->categoriaRepository->findById($data['categoria_id']);
            $noticia->setCategoria($categoria);
            
        }

        return $noticia;
    }
}
