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
        $query = "SELECT t.*, a.display_name, t.image_path
              FROM TICKET t 
              LEFT JOIN ACCOUNT a ON t.author = a.account_id
              ORDER BY t.date DESC
              LIMIT 5";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getAllTickets() {
        $query = "SELECT t.*, a.display_name AS username, t.image_path AS image_path, a.image_path AS author_image_path
              FROM TICKET t 
              LEFT JOIN ACCOUNT a ON t.author = a.account_id
              ORDER BY t.date DESC";
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

    public function getCategoriesForTicket($ticketId) {
        $query = "SELECT c.title FROM TICKET_CATEGORIES tc 
                  JOIN CATEGORY c ON tc.category_id = c.category_id 
                  WHERE tc.ticket_id = :ticket_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ticket_id', $ticketId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllCategories() {
        $query = "SELECT * FROM CATEGORY";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function getComments($ticket_id) {
        $comment_query = "SELECT c.*, a.display_name AS username FROM COMMENT c LEFT JOIN ACCOUNT a ON c.author = a.account_id WHERE c.ticket_id = :ticket_id ORDER BY date DESC";
        $comment_stmt = $this->db->prepare($comment_query);
        $comment_stmt->bindParam(':ticket_id', $ticket_id);
        $comment_stmt->execute();
        return $comment_stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCommentsWithLikes($ticket_id) {
        $query = "
        SELECT COMMENT.*, COUNT(COMMENT_LIKE.comment_id) AS like_count
        FROM COMMENT
        LEFT JOIN COMMENT_LIKE ON COMMENT.comment_id = COMMENT_LIKE.comment_id
        WHERE COMMENT.ticket_id = :ticket_id
        GROUP BY COMMENT.comment_id
        ORDER BY like_count DESC
    ";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ticket_id', $ticket_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function addTicketCategory($ticketId, $categoryId) {
        $query = "INSERT INTO TICKET_CATEGORIES (ticket_id, category_id) VALUES (:ticket_id, :category_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ticket_id', $ticketId);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->execute();
    }

    public function getTicketsByCategoriesAndSearch($categories, $searchTerm) {
        $params = [];
        $whereClauses = [];

        // Filtrer par catégories si sélectionné
        if (!empty($categories)) {
            $categoryPlaceholders = implode(',', array_fill(0, count($categories), '?'));
            $whereClauses[] = "CATEGORY.category_id IN ($categoryPlaceholders)";
            $params = array_merge($params, $categories);
        }

        // Filtrer par terme de recherche si fourni
        if (!empty($searchTerm)) {
            $searchTermWithWildcards = '%' . $searchTerm . '%';
            $whereClauses[] = "(TICKET.title LIKE ? OR TICKET.message LIKE ? OR CATEGORY.title LIKE ? OR CATEGORY.description LIKE ?)";
            $params = array_merge($params, [$searchTermWithWildcards, $searchTermWithWildcards, $searchTermWithWildcards, $searchTermWithWildcards]);
        }

        // Construire la requête
        $query = "SELECT * FROM TICKET 
              LEFT JOIN TICKET_CATEGORIES ON TICKET.ticket_id = TICKET_CATEGORIES.ticket_id 
              LEFT JOIN CATEGORY ON TICKET_CATEGORIES.category_id = CATEGORY.category_id";

        // Ajouter les clauses WHERE si nécessaire
        if (!empty($whereClauses)) {
            $query .= ' WHERE ' . implode(' AND ', $whereClauses);
        }

        // Exécuter la requête
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function likeComment($accountId, $commentId) {
        $checkQuery = "SELECT * FROM COMMENT_LIKE WHERE account_id = :account_id AND comment_id = :comment_id";
        $checkStmt = $this->db->prepare($checkQuery);
        $checkStmt->bindParam(':account_id', $accountId);
        $checkStmt->bindParam(':comment_id', $commentId);
        $checkStmt->execute();

        if ($checkStmt->fetch()) {
            return;
        }

        $query = "INSERT INTO COMMENT_LIKE (account_id, comment_id) VALUES (:account_id, :comment_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':account_id', $accountId);
        $stmt->bindParam(':comment_id', $commentId);
        $stmt->execute();
    }



}
