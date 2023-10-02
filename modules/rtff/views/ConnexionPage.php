<?php
namespace rtff\views;

class ConnexionPage
{
    public function show(): void
    {
        ob_start();
        ?>
        <div>
            <!-- Formulaire de connexion -->
            <form method="post" action="../authentication/ConnectUser">
                <label for="account_id"> Email<br>
                    <input type="email" name="account_id" required>
                </label><br>

                <label for="password"> Mot de Passe<br>
                    <input type="password" name="password" required><br>
                </label><br>

                <input type="submit" value="Se connecter"><br>
            </form><br>
            <a href="requestMailForReset.php">Mot de passe oublié</a><br>
            <a href="createUser.php">Créer un compte</a>
        </div>
        <?php
        (new \rtff\views\Layout('Login', ob_get_clean()))->show();
    }
}
