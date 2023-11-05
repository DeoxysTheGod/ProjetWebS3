<?php

namespace rtff\models;

use rtff\database\DatabaseConnexion;

class ProfileModel {
    public function updateProfileImage($userId, $imagePath) {
        $database = DatabaseConnexion::getInstance();
        $db = $database->getConnection();

        $updateQuery = "UPDATE ACCOUNT SET image_path = :image WHERE user_id = :userId";
        $stmt = $db->prepare($updateQuery);
        $stmt->bindParam(':image', $imagePath);
        $stmt->bindParam(':userId', $userId);

        return $stmt->execute();
    }
}