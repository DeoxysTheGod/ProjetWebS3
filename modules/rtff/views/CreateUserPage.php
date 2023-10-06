<?php
namespace rtff\views;
class CreateUserPage
{
	public function show(): void
	{
		ob_start();
?>
<form method="post" action="createPost.php" enctype="multipart/form-data">
    <div>
        <label for="title">Titre:</label>
        <input type="text" name="title" id="title" required>
    </div>
    <div>
        <label for="message">Message:</label>
        <textarea name="message" id="message" required></textarea>
    </div>
    <div>
        <label for="image">Image:</label>
        <input type="file" name="image" id="image">
    </div>
    <div>
        <input type="submit" value="Créer Post">
    </div>
</form>

<?php
        (new \rtff\views\Layout('Creation d\'utilisateur', ob_get_clean()))->show();
	}
}