<?php
namespace rtff\views;

class ConnexionPage
{
    public function show(): void
    {
        ob_start();
        ?>
        <link rel="stylesheet" href="/assets/styles/connexion-page.css">
        <div class="content">
            <!-- Formulaire de connexion -->
            <form method="post" action="/authentication">

                <label for="account_id"> Email<br>
                    <input type="email" name="account_id" required>
                </label><br>

                <label for="password"> Mot de Passe<br>
                    <input type="password" name="password" required><br>
                </label><br>

                <input type="submit" value="Se connecter"><br>
            </form><br>
            <a href="/authentication/reset-password">Mot de passe oublié</a><br>
            <a href="/authentication/create-user">Créer un compte</a>
        </div>
        <?php
        (new Layout('Login', ob_get_clean()))->show();
    }
}
