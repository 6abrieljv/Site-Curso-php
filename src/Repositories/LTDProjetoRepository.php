<?php

namespace App\Repositories;

use App\Database\Database;
use App\Models\LTDProjeto;
use PDO;

class LTDProjetoRepository
{
    private $db;
    private $dbParticipantes;
    private $dbTecnologias;

    public function __construct()
    {
        $this->db = new Database('ltd_projeto');
        $this->dbParticipantes = new Database('ltd_projeto_participantes');
        $this->dbTecnologias = new Database('ltd_projeto_tecnologias');
    }

    /**
     * Salva um projeto e suas relações (participantes e tecnologias).
     * Usa uma transação para garantir a integridade dos dados.
     */
    public function save(LTDProjeto $projeto, array $participantesIds, array $tecnologiasIds): int
    {
        // Inicia a transação
        $this->db->execute('START TRANSACTION');

        try {
            // 1. Salva os dados principais do projeto na tabela 'ltd_projetos'
            $projetoValues = [
                'nome' => $projeto->getNome(),
                'descricao' => $projeto->getDescricao(),
                'status' => $projeto->getStatus(),
                'periodo' => $projeto->getPeriodo(),
                'github_url' => $projeto->getGithub(),
                'imagem_path' => $projeto->getImagem()
            ];

            // Se for um novo projeto (sem ID), insere. Se não, atualiza.
            if (empty($projeto->getId())) {
                $projetoId = $this->db->insert($projetoValues);
            } else {
                $projetoId = $projeto->getId();
                $this->db->update($projetoValues, 'id = :id', ['id' => $projetoId]);
            }

            // 2. Gerencia os participantes
            // Primeiro, remove todas as associações antigas
            $this->dbParticipantes->delete('id_projeto = :id_projeto', ['id_projeto' => $projetoId]);
            // Depois, insere as novas
            foreach ($participantesIds as $usuarioId) {
                $this->dbParticipantes->insert([
                    'id_projeto' => $projetoId,
                    'id_usuario' => (int)$usuarioId
                ]);
            }

            // 3. Gerencia as tecnologias
            // Primeiro, remove todas as associações antigas
            $this->dbTecnologias->delete('id_projeto = :id_projeto', ['id_projeto' => $projetoId]);
            // Depois, insere as novas
            foreach ($tecnologiasIds as $tecnologiaId) {
                $this->dbTecnologias->insert([
                    'id_projeto' => $projetoId,
                    'id_tecnologia' => (int)$tecnologiaId
                ]);
            }

            // Se tudo deu certo, confirma a transação
            $this->db->execute('COMMIT');

            return $projetoId;

        } catch (\Exception $e) {
            // Se algo deu errado, desfaz tudo
            $this->db->execute('ROLLBACK');
            // Idealmente, você logaria o erro em vez de usar die()
            die('Erro ao salvar o projeto: ' . $e->getMessage());
        }
    }
    
    public function findAll(){
        $projetos = $this->db->select(order: 'id DESC');
        return $projetos->fetchAll();
    }

    public function findById(int $id): ?LTDProjeto
    {
        $stmt = $this->db->select('id = :id', ['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($data) {
            $projeto = new LTDProjeto();
            $projeto->setId($data['id']);
            $projeto->setNome($data['nome']);
            $projeto->setDescricao($data['descricao']);
            $projeto->setStatus($data['status']);
            $projeto->setPeriodo($data['periodo']);
            $projeto->setGithub($data['github_url']);
            $projeto->setImagem($data['imagem_path']);
            return $projeto;
        }
        
        return null;
    }

    public function delete(int $id): bool
    {
        // Inicia a transação
        $this->db->execute('START TRANSACTION');

        try {
            // Remove as associações de participantes
            $this->dbParticipantes->delete('id_projeto = :id_projeto', ['id_projeto' => $id]);
            // Remove as associações de tecnologias
            $this->dbTecnologias->delete('id_projeto = :id_projeto', ['id_projeto' => $id]);
            // Remove o projeto
            $this->db->delete('id = :id', ['id' => $id]);

            // Se tudo deu certo, confirma a transação
            $this->db->execute('COMMIT');
            return true;

        } catch (\Exception $e) {
            // Se algo deu errado, desfaz tudo
            $this->db->execute('ROLLBACK');
            // Idealmente, você logaria o erro em vez de usar die()
            die('Erro ao deletar o projeto: ' . $e->getMessage());
        }
    }

    public function findParticipantesByProjetoId(int $projetoId): array
    {
        $stmt = $this->dbParticipantes->select('id_projeto = :id_projeto', ['id_projeto' => $projetoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update(LTDProjeto $projeto, array $participantesIds, array $tecnologiasIds): int
    {
        return $this->save($projeto, $participantesIds, $tecnologiasIds);
    }
}