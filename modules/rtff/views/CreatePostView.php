<?php
namespace rtff\views;

use PDO;
use rtff\models\CategoryModel;

/**
 * Class CreatePostView
 *
 * Responsible for rendering the view to create a new post.
 */
class CreatePostView {
    private PDO $db;

    /**
     * CreatePostView constructor.
     *
     * @param PDO $db Database connection object
     */
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Render the view to create a new post.
     */
    public function show(): void {
        $categoriesModel = new CategoryModel($this->db);
        $categories = $categoriesModel->getAllCategories();

        // Start capturing the output
        ob_start();
        ?>
        <!-- Link to the stylesheets -->
        <link rel="stylesheet" href="/assets/styles/post-create.css">
        <link rel="stylesheet" href="/assets/styles/style.css">

        <!-- Content Section -->
        <section class="content">
            <!-- Form for creating a new post -->
            <form method="post" action="/post/create" enctype="multipart/form-data">
                <!-- Post Title -->
                <div>
                    <label for="title">Titre</label><br>
                    <input type="text" name="title" id="title" required>
                </div>
                <!-- Post Message -->
                <div>
                    <label for="message">Message</label><br>
                    <textarea name="message" id="message" required></textarea>
                </div>
                <!-- Image Upload -->
                <div>
                    <label for="image">Image</label><br>
                    <input type="file" name="image" id="image">
                </div>
                <!-- Categories Selection -->
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
                <!-- Submit Button -->
                <div>
                    <input type="submit" value="Créer le post">
                </div>
            </form>
        </section>
        <?php
        // End capturing the output
        $content = ob_get_clean();

        // Render the layout
        (new Layout('Création de post', $content))->show();
    }
}
