<?php

namespace rtff\views;

// modules/rtff/views/TicketView.php
namespace rtff\views;

use rtff\models\TicketModel;

class TicketView {
    private $model;

    public function __construct(TicketModel $model) {
        $this->model = $model;
    }

    public function renderPost($row) {
        $title = htmlspecialchars($row['title'] ?? 'Titre inconnu');
        $message = htmlspecialchars($row['message'] ?? 'Message inconnu');
        $username = htmlspecialchars($row['username'] ?? 'Auteur inconnu');
        $date = htmlspecialchars($row['date'] ?? 'Date inconnue');
        $imagePath = htmlspecialchars($row['image_path'] ?? '');
        $profileImage = htmlspecialchars($row['profile_image'] ?? '');
        $ticketId = htmlspecialchars($row['ticket_id'] ?? '');

        // Récupérer les catégories
        $categories = $this->model->getCategoriesForTicket($ticketId);
        $categoryNames = array_map(function($category) {
            return htmlspecialchars($category['title']);
        }, $categories);

        // Image de profil par défaut
        $defaultProfileImage = "/uploads/profiles/defaultprofile.jpeg";
        ?>
        <link rel="stylesheet" href="/assets/styles/view-posts.css">
        <div style='border: 1px solid #ccc; margin-bottom: 10px; padding: 10px;'>
            <h2><?= $title ?></h2>
            <?php if (!empty($categoryNames)): ?>
                <p><strong>Catégories :</strong> <?= implode(', ', $categoryNames) ?></p>
            <?php endif; ?>
            <p><?= $message ?></p>
            <?php if ($imagePath !== ''): ?>
                <img class='image-post' src='/<?= $imagePath ?>' alt='Image associée'/>
            <?php endif; ?>
            <p>
                <strong>Auteur :</strong>
                <?php if ($profileImage !== ''): ?>
                    <img class='profile-image' src='/<?= $profileImage ?>' alt='Profile Image' />
                <?php else: ?>
                    <img class='profile-image' src='<?= $defaultProfileImage ?>' alt='Default Profile Image' />
                <?php endif; ?>
                <?= $username ?>
            </p>
            <p><strong>Date :</strong> <?= $date ?></p>
            <a href='/pages/view-ticket?ticket_id=<?= $ticketId ?>'>Répondre</a>
        </div>
        <?php
    }



    public function render($tickets, $categories) {
        if (isset($_SESSION['account_id'])) {
            // Si l'utilisateur est connecté, affichez le bouton de déconnexion
            echo "<a href='/authentication/logout'>Déconnexion</a>";
        } else {
            // Si l'utilisateur n'est pas connecté, affichez le bouton de connexion
            echo "<a class='connection' href='/authentication'>Connexion</a>";
        }

        // Formulaire pour filtrer les posts par catégories et rechercher des mots-clés
        echo "<form class='options' method='GET' action='/post/view-posts'>";
        echo "<label for='categories'>Filtrer par catégorie:</label>";
        echo "<select id='categories' name='categories[]' multiple>";
        foreach ($categories as $category) {
            echo "<option value='" . htmlspecialchars($category['category_id']) . "'>" . htmlspecialchars($category['title']) . "</option>";
        }
        echo "</select>";
        echo "\t";

        // Champ de recherche
        echo "<input type='text' id='search' name='search' placeholder='Recherche...'>";

        echo "<input type='submit' value='Filtrer/Rechercher'>";
        echo "</form>";

        foreach ($tickets as $row) {
            $this->renderPost($row);
        }
    }


    public function renderSingleTicket($ticket, $comments) {
        echo "<!DOCTYPE html>";
        echo "<html lang='fr'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<title>View Ticket</title>";
        echo "</head>";
        echo "<body>";
        echo "<div>";
        echo "<h1>" . htmlspecialchars($ticket['title']) . "</h1>";
        echo "<p>" . htmlspecialchars($ticket['message']) . "</p>";
        echo "<p><strong>Auteur :</strong> " . htmlspecialchars($ticket['username']) . "</p>";
        echo "<p><strong>Date :</strong> " . htmlspecialchars($ticket['date']) . "</p>";
        echo "<h2>Commentaires</h2>";
        echo "<form method='post' action='/pages/view-ticket?ticket_id=" . htmlspecialchars($ticket['ticket_id']) . "'>";
        echo "<textarea name='comment' required></textarea><br>";
        echo "<input type='submit' value='Poster le Commentaire'>";
        echo "</form>";
        foreach ($comments as $comment) {
            echo "<div>";
            echo "<p>" . htmlspecialchars($comment['text']) . "</p>";
            echo "<p><strong>Date :</strong> " . htmlspecialchars($comment['date']) . "</p>";
            echo "<p><strong>Likes :</strong> " . htmlspecialchars($comment['like_count']) . "</p>";
            echo "<a href='/pages/like-comment?comment_id=" . htmlspecialchars($comment['comment_id']) . "'>Like</a>";
            echo "</div>";

        }
        echo "</div>";
        echo "</body>";
        echo "</html>";
    }
}
