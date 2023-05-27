<?php

(new \App\Models\DotEnvEnvironment())->load(__DIR__ . '/../');

class Db
{

    private static $instance = null;
    private $conn;

    // Database credentials
    protected $host = null;
    protected $name = null;
    protected $username = null;
    protected $password = null;

    private function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->name = $_ENV['DB_NAME'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->name, $this->username,  $this->password);
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
