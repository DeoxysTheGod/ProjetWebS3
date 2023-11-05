<?php

namespace rtff\models;

use PDO;

/**
 * Model class responsible for administrative tasks such as fetching and deleting posts, users, comments, and categories.
 */
class AdminModel {
    private PDO $db;

    /**
     * Constructs the AdminModel with a database connection.
     *
     * @param PDO $db The database connection.
     */
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Fetches all categories from the database.
     *
     * @return array An array of categories.
     */
    public function getAllCategories(): array {
        $query = "SELECT * FROM CATEGORY";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Fetches all posts along with their author's display name from the database.
     *
     * @return array An array of posts.
     */
    public function getAllPosts(): array {
        $query = "SELECT t.*, a.display_name AS username 
                  FROM TICKET t 
                  LEFT JOIN ACCOUNT a ON t.author = a.account_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Deletes a post and its associated comments from the database.
     *
     * @param int $ticketId The ID of the post to be deleted.
     */
    public function deletePost(int $ticketId): void {
        $commentQuery = "DELETE FROM COMMENT WHERE ticket_id = :ticket_id";
        $commentStmt = $this->db->prepare($commentQuery);
        $commentStmt->bindParam(':ticket_id', $ticketId);
        $commentStmt->execute();

        $query = "DELETE FROM TICKET WHERE ticket_id = :ticket_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ticket_id', $ticketId);
        $stmt->execute();
    }

    /**
     * Deletes a user from the database.
     *
     * @param string $userId The ID of the user to be deleted.
     */
    public function deleteUser(string $userId): void {
        $query = "DELETE FROM ACCOUNT WHERE account_id = :account_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':account_id', $userId);
        $stmt->execute();
    }

    /**
     * Deletes a comment from the database.
     *
     * @param int $commentId The ID of the comment to be deleted.
     */
    public function deleteComment(int $commentId): void {
        $query = "DELETE FROM COMMENT WHERE comment_id = :comment_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':comment_id', $commentId);
        $stmt->execute();
    }

    /**
     * Fetches all users from the database.
     *
     * @return array An array of users.
     */
    public function getAllUsers(): array {
        $query = "SELECT * FROM ACCOUNT";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Fetches all comments along with their associated ticket title and author's display name from the database.
     *
     * @return array An array of comments.
     */
    public function getAllComments(): array {
        $query = "SELECT c.*, t.title as ticket_title, a.display_name as username 
                  FROM COMMENT c 
                  LEFT JOIN TICKET t ON c.ticket_id = t.ticket_id
                  LEFT JOIN ACCOUNT a ON c.author = a.account_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
