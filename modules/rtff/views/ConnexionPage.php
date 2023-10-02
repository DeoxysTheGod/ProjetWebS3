<?php
namespace rtff\views;

class ConnexionPage
{
    public function show(): void
    {
        ob_start();
?><div style="margin-left:220px; padding:10px;">
    <!-- Formulaire de connexion -->
    <form method="post" action="connectUser.php">
        Email: <input type="email" name="account_id" required><br>
        Mot de Passe: <input type="password" name="password" required><br>
        <input type="submit" value="Se connecter">
    </form>
    <a href="requestMailForReset.php">Mot de passe oublié</a><br>
    <a href="createUser.php">Créer un compte</a>
</div>
<?php
        (new \rtff\views\Layout('Login', ob_get_clean()))->show();
    }
}