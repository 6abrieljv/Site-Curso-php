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
        $this->db = new Database('ltd_projetos');
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
    
    // O método findAll() e outros virão aqui...
}