<?php

namespace rtff\models;

use Exception;
use PDO;
use rtff\database\DatabaseConnexion;

class User {

    /**
     * Authenticates a user and sets session variables accordingly.
     *
     * @param string $account_id The email address of the user.
     * @param string $password The password of the user.
     * @return string A message indicating the result of the operation.
     */
    public static function connectUser(string $account_id, string $password): string {
        try {
            // Get database connection
            $database = DatabaseConnexion::getInstance();
            $db = $database->getConnection();

            // Retrieve the password and admin status from the database
            $query = "SELECT password, admin FROM ACCOUNT WHERE account_id = :account_id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':account_id', $account_id);
            $stmt->execute();

            // Check if account exists
            if ($stmt->rowCount() == 0) {
                return "Incorrect identifier.";
            }

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashed_password = $row['password'];

            // Verify the password
            if (!password_verify($password, $hashed_password)) {
                return "Incorrect password.";
            }

            // Successful authentication
            $_SESSION['account_id'] = $account_id;
            $_SESSION['admin'] = $row['admin'];  // Store admin status in session

            // Update the last connection date
            $updateQuery = "UPDATE ACCOUNT SET last_connection_date = DATE_FORMAT(NOW(), '%Y-%m-%d') WHERE account_id = :account_id";
            $updateStmt = $db->prepare($updateQuery);
            $updateStmt->bindParam(':account_id', $account_id);
            $updateStmt->execute();

            // Redirect to the posts viewing page
            header('Location: /post/view-posts');
            exit();

        } catch (Exception $e) {
            error_log($e->getMessage());
            return "An error occurred during the connection.";
        }
    }


    /**
     * Create a new user in the database and send a welcome email.
     *
     * @param string $account_id The email address of the new user.
     * @param string $password The password of the new user.
     * @param string $image_path The path to the profile image of the new user.
     * @param string $display_name The display name of the new user.
     * @return string A message indicating the result of the operation.
     */
    public static function createUser(string $account_id, string $password, string $image_path, string $display_name): string {
        try {
            // Get database connection
            $database = DatabaseConnexion::getInstance();
            $db = $database->getConnection();

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Check if the email is already used
            $query_check = "SELECT COUNT(*) FROM ACCOUNT WHERE account_id = :account_id";
            $stmt_check = $db->prepare($query_check);
            $stmt_check->bindParam(':account_id', $account_id);
            $stmt_check->execute();

            if ($stmt_check->fetchColumn() > 0) {
                return "This email address is already in use. Please choose a different one.";
            } else {
                // Insert the new user into the database
                $query = "INSERT INTO ACCOUNT (account_id, password, image_path, display_name, creation_date, last_connection_date) VALUES (:account_id, :password, :image_path, :display_name, NOW(), NOW())";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':account_id', $account_id);
                $stmt->bindParam(':password', $hashedPassword);
                $stmt->bindParam(':display_name', $display_name);
                $stmt->bindParam(':image_path', $image_path);

                if (!$stmt->execute()) {
                    throw new Exception("An error occurred while creating the user.");
                }

                // Send the welcome email
                self::sendEmail($account_id);
                self::connectUser($account_id, $password);
                return "User successfully created!";
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return "An error occurred.";
        }
    }



    /**
     * Send a welcome email upon account creation.
     *
     * @param string $account_id The email address of the recipient.
     * @throws Exception If the email fails to send.
     */
    private static function sendEmail(string $account_id): void {
        $to = 'Recipient Name <' . $account_id . '>';
        $subject = mb_encode_mimeheader('Account Creation RT*F');
        $bndary = md5(uniqid(mt_rand()));

        // Prepare email headers
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: multipart/alternative; boundary="' . $bndary . '"';

        // Prepare plain text email content
        $message_text = 'Thank you for creating your account on RT*F';

        // Prepare HTML email content
        $message_html = '<html lang="en"><head><title>Welcome to RT*F!</title></head><body style="background-color: #2c2a2e; color: white; text-align: center; padding: 20px;"><p>Thank you for creating your account with us!</p></body></html>';

        // Construct the multipart message
        $message = '--' . $bndary . "\r\n";
        $message .= 'Content-Type: text/plain; charset=utf-8' . "\r\n";
        $message .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";
        $message .= $message_text . "\r\n\r\n";

        $message .= '--' . $bndary . "\r\n";
        $message .= 'Content-Type: text/html; charset=utf-8' . "\r\n";
        $message .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";
        $message .= $message_html . "\r\n\r\n";

        $message .= '--' . $bndary . '--';

        // Send the email and handle any errors
        if (!mail($to, $subject, $message, $headers)) {
            throw new Exception("An error occurred while sending the email.");
        }
    }

}
