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

        $database = DatabaseConnexion::getInstance();
        $db = $database->getConnection();
        $categoriesModel = new CategoryModel($db);
        $categories = $categoriesModel->getAllCategories();

        ob_start();
        ?>
        <main id="container" class="view-post">

        <section id="content">
        <div id="ticket-container"
        <div class="ticket">

            <form class="form" method="post" action="/post/create" enctype="multipart/form-data">
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
                    <input class="classic-button" type="submit" value="Créer le post">
                </div>
            </form>
        </div>
        </section>
        </section>
        </main>
        <?php
        (new Layout('Création de post', ob_get_clean()))->show();
    }
}
