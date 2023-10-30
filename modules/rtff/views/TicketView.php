<?php

namespace rtff\views;

class TicketView {

    public function renderAllTickets($tickets) {
        echo '<!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Liste des Tickets</title>
        </head>
        <body>
        <div style="margin-left:220px; padding:10px;">
            <h1>Liste des Tickets</h1>';

        if (count($tickets) > 0) {
            foreach ($tickets as $ticket) {
                $this->renderTicket($ticket);
            }
        } else {
            echo '<p>Aucun ticket disponible pour le moment.</p>';
        }

        echo '</div>';
        echo '</body>
        </html>';
    }

    private function renderTicket($ticket) {
        echo '<div style="border: 1px solid #ccc; margin-bottom: 10px; padding: 10px;">';
        echo '<h2>' . htmlspecialchars($ticket['title']) . '</h2>';
        echo '<p>' . htmlspecialchars($ticket['message']) . '</p>';
        echo '<p><strong>Auteur :</strong> ' . htmlspecialchars($ticket['username']) . '</p>';
        echo '<p><strong>Date :</strong> ' . htmlspecialchars($ticket['date']) . '</p>';
        echo '</div>';
    }
}
