<?php

class Database{

    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=seu_banco_de_dados', 'usuario', 'senha');
        
    }
    public static function query($query, $params = [], $class){
        
        $prepare = $this->db->prepare($query);
        if(!$prepare){
            throw new Exception("Erro ao preparar a query: " . implode(", ", $this->db->errorInfo()));
        }


        if($class){
            $this->db->setFetcMode(PDO::FETCH_CLASS, $class);
        }
        $prepare->execute($params);
        return $prepare;

    }
}