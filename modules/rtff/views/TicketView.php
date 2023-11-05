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
            echo "<img src='{$imagePath}' alt='Image associée' style='width: 200px; height: auto;'/>";
        }

        echo "<p><strong>Auteur :</strong> {$username}</p>";
        echo "<p><strong>Date :</strong> {$date}</p>";
        echo "<a href='viewTicket.php?ticket_id={$ticketId}' style='padding: 10px; background-color: blue; color: white; text-decoration: none; border-radius: 5px;'>Répondre</a>";
        echo "<button style='background-color: transparent; border: none; cursor: pointer; padding: 0; margin: 0; display: inline-block;'>";
        echo "<img src='like.png' alt='Like' style='width: 25px; height: 25px;'/>";
        echo "</button>";
        echo "</div>";
    }

    public function render($tickets) {
        foreach ($tickets as $row) {
            $this->renderPost($row);
        }
    }
}
