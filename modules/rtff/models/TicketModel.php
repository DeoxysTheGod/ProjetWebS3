<?php

namespace rtff\models;

use rtff\database\DatabaseConnexion;
use PDOException;

class TicketModel {

    public function getTicketsWithAuthor() {
        $database = DatabaseConnexion::getInstance();
        $db = $database->getConnection();

        $query = "SELECT t.*, a.display_name AS username FROM TICKET t LEFT JOIN ACCOUNT a ON t.author = a.account_id";
        $stmt = $db->prepare($query);

        try {
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Erreur: " . $e->getMessage());
            return [];
        }
    }
}
