<?php

class Db
{
    private static $instance = null;
    private $conn;

    // Database credentials
    const DB_HOST = 'localhost';
    const DB_NAME = 'digihub';
    const DB_USERNAME = 'root';
    const DB_PASSWORD = '';

    private function __construct()
    {
        try {
            $this->conn = new PDO('mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME, self::DB_USERNAME, self::DB_PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec('SET NAMES "utf8"');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Db();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function query($sql)
    {
        return $this->conn->query($sql);
    }

    public function prepare($sql)
    {
        return $this->conn->prepare($sql);
    }

    public static function quickFetch($table, $column, $value)
    {
        $conn = Db::getInstance()->getConnection();
        $sql = $conn->prepare("SELECT * FROM $table WHERE $column = '$value'");
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function quickFetchAll($table, $column, $value)
    {
        $conn = Db::getInstance()->getConnection();
        $sql = $conn->prepare("SELECT * FROM $table WHERE $column = '$value'");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
