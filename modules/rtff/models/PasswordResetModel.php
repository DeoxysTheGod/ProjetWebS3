<?php
namespace rtff\models;

use rtff\database\DatabaseConnexion;
use PDO;

class PasswordResetModel {
    private $db;

    public function __construct() {
        $database = \rtff\database\DatabaseConnexion::getInstance();
        $this->db = $database->getConnection();
    }

    public function isValidToken($token) {
        $query = "SELECT * FROM TOKEN WHERE token_id = :token_id AND date_creation >= NOW() - INTERVAL 30 MINUTE";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':token_id', $token);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function resetPassword($token, $newPassword) {
        $new_password = password_hash($newPassword, PASSWORD_BCRYPT);

        $query = "UPDATE ACCOUNT SET password = :new_password WHERE account_id= :account_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':new_password', $new_password);
        $stmt->bindParam(':account_id', $account['account_id']);

        if ($stmt->execute()) {
            $this->deleteToken($token);
            return true;
        } else {
            return false;
        }
    }

    public function deleteToken($token) {
        $query = "DELETE FROM TOKEN WHERE token_id = :token_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':token_id', $token);
        $stmt->execute();
    }
}
