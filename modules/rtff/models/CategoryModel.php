<?php

namespace rtff\models;

use PDO;

class CategoryModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllCategories() {
        $query = "SELECT * FROM CATEGORY";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCategoriesSortedByUsage() {
        $query = "
            SELECT CATEGORY.*, COUNT(TICKET_CATEGORIES.id_ticket) AS usage_count
            FROM CATEGORY
            LEFT JOIN TICKET_CATEGORIES ON CATEGORY.category_id = TICKET_CATEGORIES.id_category
            GROUP BY CATEGORY.category_id
            ORDER BY usage_count DESC
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addCategory($title, $description) {
        // Ajoute une nouvelle catégorie
        $query = "INSERT INTO CATEGORY (title, description) VALUES (:title, :description)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->execute();
    }

    public function deleteCategory($categoryId) {
        // Supprime une catégorie
        $query = "DELETE FROM CATEGORY WHERE category_id = :category_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->execute();
    }
}
