<?php
namespace rtff\views;
class CreateUserPage
{
	public function show(): void
	{
		ob_start();
?><form method="post" action="/modules/rtff/controllers/authentication/CreateUser.php">
	<label for="user_id">Email
        <input type="email" name="user_id" required>
    </label>
    <label for="password">Mot de Passe
        <input type="password" name="password" required><br>
    </label>

	<label for="display_name">Nom d'Affichage
        <input type="text" name="display_name" required>
    </label>
	<label for="image">Image
        <input type="text" name="image">
    </label><br>
	<input type="submit" value="Créer l'utilisateur">
</form>
<?php
        (new \rtff\views\CreateUserPage())->show();
	}
}