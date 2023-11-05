<?php

namespace rtff\models;

use PDO;

/**
 * Model class for managing tickets and related operations.
 */
class TicketModel {
    private PDO $db;

    /**
     * Constructor initializes the database connection.
     *
     * @param PDO $db Database connection object.
     */
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Retrieves the last five tickets from the database.
     *
     * @return array Array of the last five tickets.
     */
    public function getLastFiveTickets(): array
    {
        $query = "SELECT t.*, a.display_name AS username, t.image_path AS image_path 
                  FROM TICKET t 
                  LEFT JOIN ACCOUNT a ON t.author = a.account_id
                  ORDER BY t.date DESC
                  LIMIT 5";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves all tickets from the database.
     *
     * @return array Array of all tickets.
     */
    public function getAllTickets(): array
    {
        $query = "SELECT t.*, a.display_name AS username, t.image_path AS image_path 
                  FROM TICKET t 
                  LEFT JOIN ACCOUNT a ON t.author = a.account_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ... rest of the methods ...

    /**
     * Retrieves a specific ticket by its ID.
     *
     * @param int $ticket_id The ID of the ticket.
     * @return array Associative array containing ticket details.
     */
    public function getTicket(int $ticket_id): array
    {
        $query = "SELECT t.*, a.display_name AS username, t.image_path AS image_path 
                  FROM TICKET t 
                  LEFT JOIN ACCOUNT a ON t.author = a.account_id 
                  WHERE t.ticket_id = :ticket_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ticket_id', $ticket_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves categories associated with a specific ticket.
     *
     * @param int $ticketId The ID of the ticket.
     * @return array Array of categories associated with the ticket.
     */
    public function getCategoriesForTicket(int $ticketId): array
    {
        $query = "SELECT c.title FROM TICKET_CATEGORIES tc 
                  JOIN CATEGORY c ON tc.category_id = c.category_id 
                  WHERE tc.ticket_id = :ticket_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ticket_id', $ticketId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves all categories from the database.
     *
     * @return array Array of all categories.
     */
    public function getAllCategories(): array
    {
        $query = "SELECT * FROM CATEGORY";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves comments associated with a specific ticket.
     *
     * @param int $ticket_id The ID of the ticket.
     * @return array Array of comments associated with the ticket.
     */
    public function getComments(int $ticket_id): array
    {
        $comment_query = "SELECT c.*, a.display_name AS username FROM COMMENT c LEFT JOIN ACCOUNT a ON c.author = a.account_id WHERE c.ticket_id = :ticket_id ORDER BY date DESC";
        $comment_stmt = $this->db->prepare($comment_query);
        $comment_stmt->bindParam(':ticket_id', $ticket_id);
        $comment_stmt->execute();
        return $comment_stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves comments with associated likes for a specific ticket.
     *
     * @param int $ticket_id The ID of the ticket.
     * @return array Array of comments with associated likes.
     */
    public function getCommentsWithLikes(int $ticket_id): array
    {
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

    /**
     * Adds a comment to a specific ticket.
     *
     * @param string $comment   The comment text.
     * @param string $author    The author of the comment.
     * @param int $ticket_id The ID of the ticket.
     */
    public function addComment(string $comment, string $author, int $ticket_id): void
    {
        $comment_query = "INSERT INTO COMMENT (text, date, author, ticket_id) VALUES (:text, NOW(), :author, :ticket_id)";
        $comment_stmt = $this->db->prepare($comment_query);
        $comment_stmt->bindParam(':text', $comment);
        $comment_stmt->bindParam(':author', $author);
        $comment_stmt->bindParam(':ticket_id', $ticket_id);
        $comment_stmt->execute();
    }

    /**
     * Adds a new post to the database.
     *
     * @param string $title     The title of the post.
     * @param string $message   The message of the post.
     * @param string $author    The author of the post.
     * @param string $imagePath The path to the image associated with the post.
     */
    public function addPost(string $title, string $message, string $author, string $imagePath): void
    {
        $query = "INSERT INTO TICKET (title, message, date, author, image_path) VALUES (:title, :message, NOW(), :author, :image_path)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':image_path', $imagePath);
        $stmt->execute();
    }

    /**
     * Associates a category with a ticket.
     *
     * @param int $ticketId   The ID of the ticket.
     * @param int $categoryId The ID of the category.
     */
    public function addTicketCategory(int $ticketId, int $categoryId): void
    {
        $query = "INSERT INTO TICKET_CATEGORIES (ticket_id, category_id) VALUES (:ticket_id, :category_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ticket_id', $ticketId);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->execute();
    }

    /**
     * Retrieves tickets filtered by categories and search term.
     *
     * @param array $categories Array of category IDs.
     * @param string $searchTerm Search term for filtering tickets.
     * @return array Array of filtered tickets.
     */
    public function getTicketsByCategoriesAndSearch(array $categories, string $searchTerm): array
    {
        $params = [];
        $whereClauses = [];

        if (!empty($categories)) {
            $categoryPlaceholders = implode(',', array_fill(0, count($categories), '?'));
            $whereClauses[] = "CATEGORY.category_id IN ($categoryPlaceholders)";
            $params = array_merge($params, $categories);
        }

        if (!empty($searchTerm)) {
            $searchTermWithWildcards = '%' . $searchTerm . '%';
            $whereClauses[] = "(TICKET.title LIKE ? OR TICKET.message LIKE ? OR CATEGORY.title LIKE ? OR CATEGORY.description LIKE ?)";
            $params = array_merge($params, [$searchTermWithWildcards, $searchTermWithWildcards, $searchTermWithWildcards, $searchTermWithWildcards]);
        }

        $query = "SELECT * FROM TICKET 
                  LEFT JOIN TICKET_CATEGORIES ON TICKET.ticket_id = TICKET_CATEGORIES.ticket_id 
                  LEFT JOIN CATEGORY ON TICKET_CATEGORIES.category_id = CATEGORY.category_id";

        if (!empty($whereClauses)) {
            $query .= ' WHERE ' . implode(' AND ', $whereClauses);
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Allows a user to like a comment.
     *
     * @param int $accountId The ID of the account liking the comment.
     * @param int $commentId The ID of the comment being liked.
     */
    public function likeComment(int $accountId, int $commentId): void
    {
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
