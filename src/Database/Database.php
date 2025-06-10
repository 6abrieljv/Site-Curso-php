<?php

namespace App\Database;

use PDO;
use PDOException;

class Database
{
    /**
     * Propriedades estáticas para configuração da conexão.
     */
    private static $host;
    private static $name;
    private static $user;
    private static $password;
    private static $port;
    private static $charset;

    /**
     * @var PDO|null A instância única da conexão PDO (Singleton).
     */
    private static $connection = null;

    /**
     * @var string O nome da tabela que a instância irá manipular.
     */
    private $table;

    /**
     * Configura estaticamente os dados de conexão com o banco.
     * Deve ser chamado uma única vez na inicialização da aplicação.
     */
    public static function config($host, $name, $user, $password, $port = 3306, $charset = 'utf8mb4')
    {
        self::$host = $host;
        self::$name = $name;
        self::$user = $user;
        self::$password = $password;
        self::$port = $port;
        self::$charset = $charset;
    }

    /**
     * Construtor da classe.
     * @param string $table O nome da tabela a ser manipulada.
     */
    public function __construct($table)
    {
        $this->table = $table;
        $this->setConnection();
    }

    /**
     * Estabelece a conexão com o banco de dados ou retorna a instância existente.
     * Implementa o padrão Singleton para evitar múltiplas conexões.
     */
    private function setConnection()
    {
        // Se a conexão ainda não foi criada, cria uma nova.
        if (self::$connection === null) {
            try {
                $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$name . ";port=" . self::$port . ";charset=" . self::$charset;
                self::$connection = new PDO($dsn, self::$user, self::$password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                // Em um ambiente de produção, seria melhor logar o erro do que expô-lo.
                die("Falha na conexão com o banco de dados: " . $e->getMessage());
            }
        }
    }

    /**
     * Executa uma query com prepared statements para evitar SQL Injection.
     * @param string $query A query SQL a ser executada.
     * @param array $params Os parâmetros para a query.
     * @return \PDOStatement
     */
    public function execute($query, $params = [])
    {
        try {
            $stmt = self::$connection->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            die("Falha na execução da query: " . $e->getMessage());
        }
    }

    /**
     * Insere um novo registro na tabela.
     * @param array $values Um array associativo de [coluna => valor].
     * @return int O ID do último registro inserido.
     */
    public function insert($values)
    {
        $fields = array_keys($values);
        // Cria os placeholders (:field) para o bind
        $binds = array_map(fn($field) => ":$field", $fields);

        $query = 'INSERT INTO ' . $this->table . ' (' . implode(',', $fields) . ') VALUES (' . implode(',', $binds) . ')';

        $this->execute($query, $values);

        // Retorna o ID do registro inserido
        return self::$connection->lastInsertId();
    }

    /**
     * Atualiza registros na tabela.
     * @param array $values Um array associativo de [coluna => valor] para atualizar.
     * @param string $where A condição da cláusula WHERE (ex: "id = :id").
     * @param array $whereParams Os parâmetros para a cláusula WHERE (ex: ['id' => 1]).
     */
    public function update($values, $where, $whereParams)
    {
        $fields = array_keys($values);
        $set = array_map(fn($field) => "$field = :$field", $fields);

        $query = 'UPDATE ' . $this->table . ' SET ' . implode(', ', $set) . ' WHERE ' . $where;

        // Combina os parâmetros dos valores a serem atualizados com os da cláusula WHERE
        $params = array_merge($values, $whereParams);

        $this->execute($query, $params);
    }

    /**
     * Deleta registros da tabela.
     * @param string $where A condição da cláusula WHERE (ex: "id = :id").
     * @param array $params Os parâmetros para a cláusula WHERE (ex: ['id' => 1]).
     */
    public function delete($where, $params)
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $where;
        $this->execute($query, $params);
    }

    /**
     * Seleciona registros da tabela.
     * @param string|null $where A condição WHERE (sem a palavra "WHERE").
     * @param string|null $order A ordenação (sem a palavra "ORDER BY").
     * @param string|null $limit O limite (sem a palavra "LIMIT").
     * @param string $fields Os campos a serem retornados.
     * @return \PDOStatement
     */
    public function select($where = null, $params = [], $order = null, $limit = null, $fields = '*')
    {
        $whereClause = !is_null($where) ? 'WHERE ' . $where : '';
        $orderClause = !is_null($order) ? 'ORDER BY ' . $order : '';
        $limitClause = !is_null($limit) ? 'LIMIT ' . $limit : '';

        $query = 'SELECT ' . $fields . ' FROM ' . $this->table . ' ' . $whereClause . ' ' . $orderClause . ' ' . $limitClause;

        return $this->execute($query, $params);
    }
}
