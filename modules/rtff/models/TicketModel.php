<?php

namespace rtff\models;

use rtff\database\DatabaseConnexion;
use PDO;
use PDOException;

class TicketModel {
    private $db;

    public function __construct() {
        $this->db = DatabaseConnexion::getInstance()->getConnection();
    }

    public function getTicket($ticketId) {
        $query = "SELECT t.*, a.display_name AS username FROM TICKET t LEFT JOIN ACCOUNT a ON t.author = a.account_id WHERE t.ticket_id = :ticket_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ticket_id', $ticketId);

        try {
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur: " . $e->getMessage());
            return false;
        }
    }

    public function getAllTickets() {
        $database = DatabaseConnexion::getInstance();
        $db = $database->getConnection();

        $query = "SELECT t.*, a.display_name AS username FROM TICKET t LEFT JOIN ACCOUNT a ON t.author = a.account_id";
        $stmt = $db->prepare($query);

        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur: " . $e->getMessage());
            return [];
        }
    }


    public function getComments($ticketId) {
        $query = "SELECT c.*, a.display_name AS username FROM COMMENT c LEFT JOIN ACCOUNT a ON c.author = a.account_id WHERE c.ticket_id = :ticket_id ORDER BY date DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ticket_id', $ticketId);

        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur: " . $e->getMessage());
            return [];
        }
    }

    public function addComment($ticketId, $commentText, $authorId) {
        $query = "INSERT INTO COMMENT (text, date, author, ticket_id) VALUES (:text, NOW(), :author, :ticket_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':text', $commentText);
        $stmt->bindParam(':author', $authorId);
        $stmt->bindParam(':ticket_id', $ticketId);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur: " . $e->getMessage());
            return false;
        }
    }
}
