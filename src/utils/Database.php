<?php

class Database{
    
    private $db;

    public function __construct(){
        $host = Config::get('database/host');
        $username = Config::get('database/username');
        $password = Config::get('database/password');
        $database = Config::get('database/database');
        $port = Config::get('database/port');
        $charset = Config::get('database/charset');
        $driver = Config::get('database/DB_DRIVER');
        $dsn = "$driver:host=$host;dbname=$database;port=$port;charset=$charset";
        try {
            $this->db = new PDO($dsn, $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection(){
        return $this->db;
    }

    public function query($sql, $params = [], $className = null) {
        $stmt = $this->db->prepare($sql);

        if ($className) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, $className);
        } 
        else {
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
        }
        if ($params) {
            foreach ($params as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
        }
        $stmt->execute();
        return $stmt;
    }

}