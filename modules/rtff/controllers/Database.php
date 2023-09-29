<?php
namespace Rtff\Controllers;
class Database {
    private $host = 'mysql-rtff.alwaysdata.net';       // Nom d'hôte de la base de données
    private $db_name = 'rtff_bd';   // Nom de la base de données
    private $username = 'rtff';     // Nom d'utilisateur de la base de données
    private $password = 'rootrtff1234*';    // Mot de passe de la base de données
    public $conn;

    // Obtenez la connexion à la base de données
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->exec('set names utf8');
        } catch (PDOException $exception) {
            echo 'Erreur de connexion : ' . $exception->getMessage();
        }

        return $this->conn;
    }
}