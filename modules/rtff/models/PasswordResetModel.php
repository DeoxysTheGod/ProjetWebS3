<?php
namespace rtff\models;

use rtff\database\DatabaseConnexion;
use PDO;

class PasswordResetModel {
    /** @var PDO Connexion à la base de données. */
    private $db;
    /**
     * Constructeur de la classe.
     *
     * Initialise la connexion à la base de données.
     */
    public function __construct() {
        $database = \rtff\database\DatabaseConnexion::getInstance();
        $this->db = $database->getConnection();
    }

    /**
     * Vérifie si un token est valide.
     *
     * @param string $token Le token à vérifier.
     *
     * @return bool Retourne true si le token est valide, sinon false.
     */
    public function isValidToken($token) {
        $query = "SELECT * FROM TOKEN WHERE token_id = :token_id AND date_creation >= NOW() - INTERVAL 30 MINUTE";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':token_id', $token);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
    /**
     * Réinitialise le mot de passe d'un utilisateur.
     *
     * @param string $token Le token de réinitialisation.
     * @param string $newPassword Le nouveau mot de passe à définir.
     *
     * @return bool Retourne true si la réinitialisation du mot de passe a réussi, sinon false.
     */
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
    /**
     * Supprime un token de la base de données.
     *
     * @param string $token Le token à supprimer.
     */
    public function deleteToken($token) {
        $query = "DELETE FROM TOKEN WHERE token_id = :token_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':token_id', $token);
        $stmt->execute();
    }
}
