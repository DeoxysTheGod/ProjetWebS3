<?php
namespace rtff\views;

/**
 * Class ConnexionPage
 * Responsible for rendering the login page.
 */
class ConnexionPage
{
    /**
     * Render the login page.
     */
    public function show(): void
    {
        // Start buffering output
        ob_start();
        ?>
        <!-- Link to the stylesheet for the login page -->
        <link rel="stylesheet" href="/assets/styles/connexion-page.css">

        <!-- Login form -->
        <div class="content">
            <form method="post" action="/authentication">
                <!-- Email input field -->
                <label for="account_id">Email<br>
                    <input type="email" name="account_id" required>
                </label><br>

                <!-- Password input field -->
                <label for="password">Password<br>
                    <input type="password" name="password" required><br>
                </label><br>

                <!-- Submit button -->
                <input type="submit" value="Log in"><br>
            </form><br>

            <!-- Links for password reset and account creation -->
            <a href="/authentication/reset-password">Forgot password</a><br>
            <a href="/authentication/create-user">Create an account</a>
        </div>
        <?php
        // Render layout with the buffered content
        (new Layout('Login', ob_get_clean()))->show();
    }
}
