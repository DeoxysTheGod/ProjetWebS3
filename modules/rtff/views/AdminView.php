<?php

namespace rtff\views;

namespace rtff\views;

class AdminView {
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
                    <a href="/admin/delete-category/<?= htmlspecialchars($category['category_id']) ?>">Supprimer</a>
                </li>
            <?php endforeach; ?>
        </ul>
        </body>
        </html>
        <?php
    }
}
