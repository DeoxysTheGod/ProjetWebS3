<?php

namespace rtff\views;

namespace rtff\views;

class AdminView {

    public function showPosts($posts) {
        echo "<h2>Gestion des Posts</h2>";
        echo "<ul>";
        foreach ($posts as $post) {
            echo "<li>";
            echo "<strong>" . htmlspecialchars($post['title']) . "</strong> par " . htmlspecialchars($post['username']);
            echo " <a href='/admin/delete-post?id=" . htmlspecialchars($post['ticket_id']) . "' style='color: red;'>Supprimer</a>";
            echo "</li>";
        }
        echo "</ul>";
    }



    public function showCategories($categories) {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Gestion des Catégories</title>
        </head>
        <body>
        <h1>Gestion des Catégories</h1>

        <!-- Formulaire pour créer une nouvelle catégorie -->
        <h2>Ajouter une nouvelle catégorie</h2>
        <form method="post" action="/admin/create-category">
            <label for="title">Titre :</label>
            <input type="text" id="title" name="title" required><br>
            <label for="description">Description :</label>
            <textarea id="description" name="description" required></textarea><br>
            <input type="submit" value="Ajouter">
        </form>

        <!-- Liste des catégories existantes -->
        <h2>Catégories existantes</h2>
        <ul>
            <?php foreach ($categories as $category): ?>
                <li>
                    <strong><?= htmlspecialchars($category['title']) ?></strong>: <?= htmlspecialchars($category['description']) ?>
                    <!-- Lien pour supprimer une catégorie -->
                    <a href='/admin/delete-category?id=<?= $category['category_id'] ?>' style='color: red;'>Supprimer</a>
                </li>
            <?php endforeach; ?>
        </ul>
        </body>
        </html>
        <?php
    }
}
