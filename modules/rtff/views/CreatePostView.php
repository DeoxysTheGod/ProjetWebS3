<?php
namespace rtff\views;

use rtff\models\CategoryModel;
use rtff\database\DatabaseConnexion;

class CreatePostView {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function show(): void {

        ob_start();
        $navbar = new Navbar();
        $navbar->show();

        $database = DatabaseConnexion::getInstance();
        $db = $database->getConnection();
        $categoriesModel = new CategoryModel($db);
        $categories = $categoriesModel->getAllCategories();

        ob_start();
        ?>
        <link rel="stylesheet" href="/assets/styles/post-create.css">
        <link rel="stylesheet" href="/assets/styles/style.css">
        <section class="content">
            <form method="post" action="/post/create" enctype="multipart/form-data">
                <div>
                    <label for="title">Titre</label><br>
                    <input type="text" name="title" id="title" required>
                </div>
                <div>
                    <label for="message">Message</label><br>
                    <textarea name="message" id="message" required></textarea>
                </div>
                <div>
                    <label for="image">Image</label><br>
                    <input type="file" name="image" id="image">
                </div>
                <div>
                    <label>Catégories</label>
                    <div>
                        <?php
                        foreach ($categories as $category) {
                            echo "<label><input type='checkbox' name='categories[]' value='{$category['category_id']}'> {$category['title']}</label><br>";
                        }
                        ?>
                    </div>
                </div>
                <div>
                    <input type="submit" value="Créer le post">
                </div>
            </form>
        </section>
        <?php
        (new Layout('Création de post', ob_get_clean()))->show();
    }
}
