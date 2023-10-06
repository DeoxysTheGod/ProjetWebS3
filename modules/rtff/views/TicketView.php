<?php

namespace rtff\views;

class TicketView {

    public function renderTickets($tickets) {
        echo '<!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Votre Page</title>
        </head>
        <body>
        <div style="margin-left:220px; padding:10px;">
            <h1>Liste des Posts</h1>';

        foreach ($tickets as $ticket) {
            $this->renderPost($ticket);
        }

        echo '</div>';
        echo '</body>
        </html>';
    }

    private function renderPost($ticket) {
        // ... comme la fonction renderPost donnée ...
    }
}
