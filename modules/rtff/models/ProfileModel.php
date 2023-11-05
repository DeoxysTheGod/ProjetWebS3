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

    public function getCurrentProfileImage($userId) {
        $database = DatabaseConnexion::getInstance();
        $db = $database->getConnection();

        $selectQuery = "SELECT image_path FROM ACCOUNT WHERE user_id = :userId";
        $stmt = $db->prepare($selectQuery);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        $result = $stmt->fetch();

        return ($result) ? $result['image_path'] : null;
    }
}