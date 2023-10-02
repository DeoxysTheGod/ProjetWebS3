<?php
namespace rtff\views;
class CreateUserPage
{
	public function show(): void
	{
		ob_start();
?><form method="post" action="/modules/rtff/controllers/authentication/CreateUser.php">
	<label for="user_id">Email<br>
        <input type="email" name="user_id" required>
    </label><br>
    <label for="password">Mot de Passe<br>
        <input type="password" name="password" required>
    </label><br>
	<label for="display_name">Nom d'Affichage<br>
        <input type="text" name="display_name" required>
    </label><br>
	<label for="image">Image<br>
        <input type="text" name="image">
    </label><br><br>
	<input type="submit" value="Créer l'utilisateur">
</form>
<?php
        (new \rtff\views\Layout('Creation d\'utilisateur', ob_get_clean()))->show();
	}
}