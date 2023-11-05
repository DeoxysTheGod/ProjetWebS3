<?php
namespace rtff\database;

use PDO;
use PDOException;

/**
 * Singleton class responsible for managing the database connection.
 */
class DatabaseConnexion
{
    private static ?DatabaseConnexion $instance = null;
    private PDO $conn;

    private string $host = 'mysql-rtff.alwaysdata.net';
    private string $db_name = 'rtff_bd';
    private string $username = 'rtff';
    private string $password = 'rootrtff1234*';

    /**
     * Private constructor to establish the database connection.
     * Ensures that the connection is established only once (Singleton Pattern).
     */
    private function __construct()
    {
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->exec('set names utf8');
        } catch (PDOException $exception) {
            echo 'Connection Error: ' . $exception->getMessage();
        }
    }

    /**
     * Gets the singleton instance of the DatabaseConnexion class.
     *
     * @return DatabaseConnexion|null The instance of the DatabaseConnexion class.
     */
    public static function getInstance(): ?DatabaseConnexion
    {
        if (self::$instance == null) {
            self::$instance = new DatabaseConnexion();
        }
        return self::$instance;
    }

    /**
     * Gets the PDO database connection object.
     *
     * @return PDO The PDO database connection object.
     */
    public function getConnection(): PDO
    {
        return $this->conn;
    }
}
