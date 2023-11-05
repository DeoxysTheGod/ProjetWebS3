<?php

namespace rtff\models;

use rtff\database\DatabaseConnexion;
use PDOException;

/**
 * Model class responsible for sending password reset emails.
 */
class MailModel {

    /**
     * Sends a password reset email to the user with the provided account ID.
     *
     * @param string $account_id The account ID (email) of the user.
     * @return bool Indicates whether the email was sent successfully.
     */
    public function sendPasswordReset(string $account_id): bool {
        try {
            $database = DatabaseConnexion::getInstance();
            $db = $database->getConnection();

            // Check if the user exists
            $query = "SELECT account_id FROM ACCOUNT WHERE account_id = :account_id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':account_id', $account_id);

            if (!$stmt->execute() || $stmt->rowCount() <= 0) {
                echo "No user found with this email.";
                return false;
            }

            // Generate a unique boundary string
            $bndary = md5(uniqid(mt_rand()));

            // Insert the token into the database
            $query = "INSERT INTO TOKEN (token_id, account_id, date_creation) VALUES (:bndary, :account_id , NOW())";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':account_id', $account_id);
            $stmt->bindParam(':bndary', $bndary);
            $stmt->execute();

            // Prepare the password reset link
            $link = "http://rtff.alwaysdata.net/authentication/reset-password-process?token=" . $bndary;

            // Prepare email headers and body
            $to = $account_id;
            $subject = 'Password Change';
            $headers = 'Content-type: multipart/alternative; boundary="' . $bndary . '"';
            $message_text = 'Click the button below to change your password: rtff.alwaysdata.net/modifyPasswordUser.php?token=bndary';
            $message_html = '
<html lang="en">
<head>
    <title>Password Change</title>
</head>
<body style="background-color: #2c2a2e; color: white; text-align: center; padding: 20px;">
<p>Click the button below to change your password:</p>
<a href=' . $link . ' style="display: inline-block; padding: 10px 20px; background-color: #b0baff; color: #000; text-decoration: none; border-radius: 5px;">Click here</a>
</body>
</html>
';

            // Construct the email body
            $message = '--' . $bndary . "\n";
            $message .= $message_text . "\n\n";
            $message .= 'Content-Type: text/plain; charset=utf-8' . "\n\n";
            $message .= '--' . $bndary . "\n";
            $message .= 'Content-Type: text/html; charset=utf-8' . "\n\n";
            $message .= $message_html . "\n\n";

            // Send the email
            if (mail($to, $subject, $message, $headers)) {
                echo "Email sent successfully.";
                return true;
            } else {
                echo "An error occurred.";
                return false;
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
