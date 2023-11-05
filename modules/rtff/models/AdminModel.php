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
        // Supprime un post
        $query = "DELETE FROM TICKET WHERE ticket_id = :ticket_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ticket_id', $ticketId);
        $stmt->execute();
    }

}
