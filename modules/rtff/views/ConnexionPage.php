<?php
namespace rtff\views;

class ConnexionPage
{
    public function show(): void
    {
        ob_start();
?><h1>Connectez-vous</h1>
<form method="post"  action="/modules/rtff/controllers/authentication/ConnectUser.php">
    Email: <input type="email" name="account_id" required><br>
    Mot de Passe: <input type="password" name="password" required><br>
    <input type="submit" value="Se connecter">
</form>
<a href="requestMailForReset.php">réinitialiser mot de passe</a>
<?php
        (new \rtff\views\Layout('Login', ob_get_clean()))->show();
    }
}