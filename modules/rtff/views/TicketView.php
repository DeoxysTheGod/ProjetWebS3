<?php

namespace rtff\views;

class TicketView {
    public function renderPost($row) {
        $title = htmlspecialchars($row['title'] ?? 'Titre inconnu');
        $message = htmlspecialchars($row['message'] ?? 'Message inconnu');
        $username = htmlspecialchars($row['username'] ?? 'Auteur inconnu');
        $date = htmlspecialchars($row['date'] ?? 'Date inconnue');
        $imagePath = htmlspecialchars($row['image_path'] ?? '');
        $ticketId = htmlspecialchars($row['ticket_id'] ?? '');



        echo "<div style='border: 1px solid #ccc; margin-bottom: 10px; padding: 10px;'>";
        echo "<h2>{$title}</h2>";
        echo "<p>{$message}</p>";

        if ($imagePath !== '') {
            echo "<img src='/$imagePath' alt='Image associée' style='width: 200px; height: auto;'/>";
        }

        echo "<p><strong>Auteur :</strong> {$username}</p>";
        echo "<p><strong>Date :</strong> {$date}</p>";
        // Modifier le lien ci-dessous
        echo "<a href='/pages/view-ticket?ticket_id={$ticketId}' style='padding: 10px; background-color: blue; color: white; text-decoration: none; border-radius: 5px;'>Répondre</a>";
        echo "<button style='background-color: transparent; border: none; cursor: pointer; padding: 0; margin: 0; display: inline-block;'>";
        echo "<img src='/like.png' alt='Like' style='width: 25px; height: 25px;'/>";
        echo "</button>";
        echo "</div>";
    }


    public function render($tickets) {
        if (isset($_SESSION['account_id'])) {
            // Si l'utilisateur est connecté, affichez le bouton de déconnexion
            echo "<a  href='/authentication/logout'>Déconnexion</a>";
        } else {
            // Si l'utilisateur n'est pas connecté, affichez le bouton de connexion
            echo "<a class='connection' href='/authentication'>Connexion</a>";
        }
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
        echo "<div style='margin-right:220px; padding:10px;'>";
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
            echo "<div style='border: 1px solid #ccc; margin-bottom: 10px; padding: 10px;'>";
            echo "<p>" . htmlspecialchars($comment['text']) . "</p>";
            echo "<p><strong>Auteur :</strong> " . htmlspecialchars($comment['username'] ?? 'Auteur inconnu') . "</p>";
            echo "<p><strong>Date :</strong> " . htmlspecialchars($comment['date']) . "</p>";
            echo "</div>";
        }
        echo "</div>";
        echo "</body>";
        echo "</html>";
    }
}
