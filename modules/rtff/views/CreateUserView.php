<?php
namespace rtff\views;

class CreateUserView
{
    public function show(): void
    {
        ob_start();
        ?>
        <form method="post" action="/authentication/create-user" enctype="multipart/form-data">
            <div>
                <label for="user_id">Adresse e-mail :</label>
                <input type="email" name="user_id" id="user_id" required>
            </div>
            <div>
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div>
                <label for="display_name">Nom d'affichage :</label>
                <input type="text" name="display_name" id="display_name" required>
            </div>
            <div>
                <input type="submit" value="Créer un compte">
            </div>
        </form>
        <?php
        (new Layout('Création d\'utilisateur', ob_get_clean()))->show();
    }
}
