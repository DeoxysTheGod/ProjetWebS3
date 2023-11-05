<?php

namespace rtff\models;

use PDO;
use rtff\database\DatabaseConnexion;
use PDOException;

class TicketModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllTickets() {
        $query = "SELECT t.*, a.display_name AS username FROM TICKET t LEFT JOIN ACCOUNT a ON t.author = a.account_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
