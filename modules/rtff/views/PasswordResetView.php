<?php
namespace rtff\views;

/**
 * Class PasswordResetView
 * Responsible for rendering the password reset view.
 */
class PasswordResetView
{
    /**
     * Render the password reset view with a message and token.
     *
     * @param string $message The message to display.
     * @param string $token The token used for password reset.
     */
    public static function render(string $message, string $token): void
    {
        // Display the message if it is not empty
        if ($message !== '') {
            ?>
            <p><?= $message ?></p>
            <?php
            // If the password was successfully changed, display the login link
            if ($message === "Mot de passe modifié avec succès !") {
                ?>
                <!DOCTYPE html>
                <html lang="fr">
                <head>
                    <title>Connectez-vous</title>
                </head>
                <body>
                <p>Cliquez sur le bouton ci-dessous pour vous connecter :</p>
                <a href="https://rtff.alwaysdata.net/">Cliquez ici</a>
                </body>
                </html>
                <?php
            }
        }

        // If the token is set and the message is empty, display the password reset form
        if (isset($token) && $message === '') {
            ?>
            <form method="post" action="/authentication/reset-password-process?token=<?= $token ?>">
                <label for="new_password">Nouveau Mot de Passe:</label>
                <input type="password" id="new_password" name="new_password" required><br>
                <input type="submit" value="Modifier Mot de Passe">
            </form>
            <?php
        }
    }
}

