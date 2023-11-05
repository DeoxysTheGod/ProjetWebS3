<?php

namespace rtff\models;

use PDO;

class AdminModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllCategories() {
        // Retourne toutes les catégories
        $query = "SELECT * FROM CATEGORY";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllPosts() {
        // Retourne tous les posts
        $query = "SELECT t.*, a.display_name AS username 
              FROM TICKET t 
              LEFT JOIN ACCOUNT a ON t.author = a.account_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deletePost($ticketId) {
        $commentQuery = "DELETE FROM COMMENT WHERE ticket_id = :ticket_id";
        $commentStmt = $this->db->prepare($commentQuery);
        $commentStmt->bindParam(':ticket_id', $ticketId);
        $commentStmt->execute();

        $query = "DELETE FROM TICKET WHERE ticket_id = :ticket_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ticket_id', $ticketId);
        $stmt->execute();
    }
    public function deleteUser($userId) {
        $query = "DELETE FROM ACCOUNT WHERE account_id = :account_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':account_id', $userId);
        $stmt->execute();
    }

    public function deleteComment($commentId) {
        $query = "DELETE FROM COMMENT WHERE comment_id = :comment_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':comment_id', $commentId);
        $stmt->execute();
    }

    public function getAllUsers() {
        $query = "SELECT * FROM ACCOUNT";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllComments() {
        $query = "SELECT c.*, t.title as ticket_title, a.display_name as username 
                  FROM COMMENT c 
                  LEFT JOIN TICKET t ON c.ticket_id = t.ticket_id
                  LEFT JOIN ACCOUNT a ON c.author = a.account_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



}
