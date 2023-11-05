<?php
namespace rtff\views;

use rtff\models\CategoryModel;
use rtff\database\DatabaseConnexion;

class CreatePostView {
    public function show(): void {
        $database = DatabaseConnexion::getInstance();
        $db = $database->getConnection();
        $categoriesModel = new CategoryModel($db);
        $categories = $categoriesModel->getAllCategories();

        ob_start();
        ?>
        <form method="post" action="/post/create" enctype="multipart/form-data">
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
                <label for="categories">Catégories:</label>
                <select name="categories[]" id="categories" multiple>
                    <?php
                    foreach ($categories as $category) {
                        echo "<option value='{$category['category_id']}'>{$category['title']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
                <input type="submit" value="Créer Post">
            </div>
        </form>
        <?php
        (new Layout('Création de post', ob_get_clean()))->show();
    }
}
