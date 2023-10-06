<?php

namespace rtff\views;

class CreateUserPage {
    public function show(): void
    {
        ob_start();
?>
        <form method="post" action="../authentication/CreateUser">
            Email: <input type="email" name="user_id" required><br>
            Mot de Passe: <input type="password" name="password" required><br>
            Nom d'Affichage: <input type="text" name="display_name" required><br>
            Image: <input type="text" name="image"><br>
            <input type="submit" value="Créer Utilisateur">
            <a href="../authentication/ConnectUser">Connectez-vous</a>
        </form>
    <?php
}
}