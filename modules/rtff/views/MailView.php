<?php

namespace rtff\views;

/**
 * MailView Class
 *
 * Provides methods to render different views for sending mail.
 */
class MailView {

    /**
     * Renders the mail form.
     */
    public function renderForm(): void {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Votre Page</title>
        </head>
        <body>
        <div style="margin-left: 220px; padding: 10px;">
            <form method="post" action="/authentication/reset-password/send-mail">
                <label for="account_id">Mail:</label>
                <input id="account_id" name="account_id" type="email" required>
                <input name="send" type="submit" value="Envoyer">
            </form>
        </div>
        </body>
        </html>
        <?php
    }

    /**
     * Renders a success message when the mail is sent successfully.
     */
    public function renderSuccess(): void {
        echo "Mail envoyé avec succès.";
    }

    /**
     * Renders an error message when there is a problem sending the mail.
     */
    public function renderError(): void {
        echo "Un problème est survenu.";
    }

    /**
     * Renders a message when no user is found with the provided email.
     */
    public function renderNoUser(): void {
        echo "Aucun utilisateur trouvé avec cet email";
    }
}
