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

    public function getLastFiveTickets() {
        $query = "SELECT t.*, a.display_name AS username, t.image_path AS image_path 
              FROM TICKET t 
              LEFT JOIN ACCOUNT a ON t.author = a.account_id
              ORDER BY t.date DESC
              LIMIT 5";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getAllTickets() {
        $query = "SELECT t.*, a.display_name AS username, t.image_path AS image_path 
              FROM TICKET t 
              LEFT JOIN ACCOUNT a ON t.author = a.account_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTicket($ticket_id) {
        $query = "SELECT t.*, a.display_name AS username, t.image_path AS image_path 
              FROM TICKET t 
              LEFT JOIN ACCOUNT a ON t.author = a.account_id 
              WHERE t.ticket_id = :ticket_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ticket_id', $ticket_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getComments($ticket_id) {
        $comment_query = "SELECT c.*, a.display_name AS username FROM COMMENT c LEFT JOIN ACCOUNT a ON c.author = a.account_id WHERE c.ticket_id = :ticket_id ORDER BY date DESC";
        $comment_stmt = $this->db->prepare($comment_query);
        $comment_stmt->bindParam(':ticket_id', $ticket_id);
        $comment_stmt->execute();
        return $comment_stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addComment($comment, $author, $ticket_id) {
        $comment_query = "INSERT INTO COMMENT (text, date, author, ticket_id) VALUES (:text, NOW(), :author, :ticket_id)";
        $comment_stmt = $this->db->prepare($comment_query);
        $comment_stmt->bindParam(':text', $comment);
        $comment_stmt->bindParam(':author', $author);
        $comment_stmt->bindParam(':ticket_id', $ticket_id);
        $comment_stmt->execute();
    }

    public function addPost($title, $message, $author, $imagePath) {
        $query = "INSERT INTO TICKET (title, message, date, author, image_path) VALUES (:title, :message, NOW(), :author, :image_path)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':image_path', $imagePath);
        $stmt->execute();
    }

}
