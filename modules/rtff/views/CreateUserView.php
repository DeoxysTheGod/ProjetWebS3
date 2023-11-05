<?php
namespace rtff\views;

class CreateUserView
{
    public function show(): void
    {
        ob_start();
        ?>
        <link rel="stylesheet" href="/assets/styles/create-user.css">
        <div class="content">
            <form method="post" action="/authentication/create-user" enctype="multipart/form-data">
                <div>
                    <label for="user_id">Adresse e-mail</label><br>
                    <input type="email" name="user_id" id="user_id" required>
                </div>
                <div>
                    <label for="password">Mot de passe</label><br>
                    <input type="password" name="password" id="password" required>
                </div>
                <div>
                    <label for="display_name">Nom d'affichage</label><br>
                    <input type="text" name="display_name" id="display_name" required>
                </div>
                <div>
                    <label for="profileImage">Image de profil</label><br>
                    <input type="file" name="profileImage" accept="image/*" required>
                </div>
                <div>
                    <input class="classic-button" type="submit" value="Créer un compte">
                </div>
            </form>
        </div>
        <?php
        (new Layout('Création d\'utilisateur', ob_get_clean()))->show();
    }
}
