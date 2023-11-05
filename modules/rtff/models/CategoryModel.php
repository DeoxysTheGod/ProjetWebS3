<?php

namespace rtff\models;

use PDO;

/**
 * Model class responsible for handling operations related to categories.
 */
class CategoryModel {
    private PDO $db;

    /**
     * Constructs the CategoryModel with a database connection.
     *
     * @param PDO $db The database connection.
     */
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Retrieves all categories from the database.
     *
     * @return array An associative array of all categories.
     */
    public function getAllCategories(): array {
        $query = "SELECT * FROM CATEGORY";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves categories sorted by usage from the database.
     *
     * @return array An associative array of categories sorted by usage.
     */
    public function getCategoriesSortedByUsage(): array {
        $query = "
            SELECT CATEGORY.title, CATEGORY.category_id, COUNT(TICKET_CATEGORIES.category_id) AS nb_usage
            FROM CATEGORY
            LEFT JOIN TICKET_CATEGORIES ON CATEGORY.category_id = TICKET_CATEGORIES.category_id
            GROUP BY CATEGORY.title, CATEGORY.category_id
            ORDER BY nb_usage DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Adds a new category to the database.
     *
     * @param string $title The title of the category.
     * @param string $description The description of the category.
     */
    public function addCategory(string $title, string $description): void {
        $query = "INSERT INTO CATEGORY (title, description) VALUES (:title, :description)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->execute();
    }

    /**
     * Deletes a category from the database.
     *
     * @param int $categoryId The ID of the category to be deleted.
     */
    public function deleteCategory(int $categoryId): void {
        $query = "DELETE FROM CATEGORY WHERE category_id = :category_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->execute();
    }
}
