<?php
class Database {
    private static $instance = null;
    private $conn;

    private $host = 'mysql-rtff.alwaysdata.net';
    private $db_name = 'rtff_bd';
    private $username = 'rtff';
    private $password = 'rootrtff1234*';

    private function __construct() {
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->exec('set names utf8');
        } catch (PDOException $exception) {
            echo 'Erreur de connexion : ' . $exception->getMessage();
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>
