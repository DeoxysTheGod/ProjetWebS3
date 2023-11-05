<?php

namespace rtff\views;

use rtff\models\TicketModel;

class TicketView {
    private TicketModel $model;

    public function __construct(TicketModel $model) {
        $this->model = $model;
    }

    /**
     * Renders a single post with details including title, message, author, date, and associated categories.
     *
     * @param array $row  Associative array containing details of a post.
     */
    public function renderPost(array $row): void {
        $title = htmlspecialchars($row['title'] ?? 'Titre inconnu');
        $message = htmlspecialchars($row['message'] ?? 'Message inconnu');
        $username = htmlspecialchars($row['username'] ?? 'Auteur inconnu');
        $date = htmlspecialchars($row['date'] ?? 'Date inconnue');
        $imagePath = htmlspecialchars($row['image_path'] ?? '');
        $ticketId = htmlspecialchars($row['ticket_id'] ?? '');

        // Retrieve categories associated with the ticket
        $categories = $this->model->getCategoriesForTicket($ticketId);
        $categoryNames = array_map(function($category) {
            return htmlspecialchars($category['title']);
        }, $categories);

        ?>
        <div class='ticket'>
            <h2><?= $title ?></h2>
            <link rel="stylesheet" href="/assets/styles/view-posts.css">
            <div style='border: 1px solid #ccc; margin-bottom: 10px; padding: 10px;'>

            <?php if (!empty($categoryNames)): ?>
                <p><strong>Catégories :</strong> <?= implode(', ', $categoryNames) ?></p>
            <?php endif; ?>

            <p><?= $message ?></p>

            <?php if ($imagePath !== ''): ?>
                <img class='image-post' src='<?= $imagePath ?>' alt='Image associée'/>
            <?php endif; ?>

            <p><strong>Auteur :</strong> <?= $username ?></p>
            <p><strong>Date :</strong> <?= $date ?></p>
            <button class='classic-button' onclick="location.href = '/pages/view-ticket?ticket_id=<?= $ticketId ?>'">Répondre</button>
        </div>
        <?php
    }

    /**
     * Renders tickets and categories, allowing filtering and searching.
     *
     * @param array $tickets     Array of associative arrays containing ticket details.
     * @param array $categories  Array of associative arrays containing category details.
     */
    public function render(array $tickets, array $categories): void {
        ob_start();
        ?>
        <main id="container" class="view-post">
            <section id="history">
                <h1 class="side-panel-title">Filtre</h1>

                <!-- Form to filter posts by categories and search keywords -->
                <form class='options' method='GET' action='/post/view-posts'>
                    <label for='categories'>Filtrer par catégorie:</label>
                    <select id='categories' name='categories[]' multiple>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= htmlspecialchars($category['category_id']); ?>">
                                <?= htmlspecialchars($category['title']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <!-- Search field -->
                    <input type='text' id='search' name='search' placeholder='Recherche...'>
                    <input type='submit' value='Filtrer/Rechercher'>
                </form>
            </section>

            <section id='content'>
                <h1>Tous les tickets</h1>
                <div id='ticket-container'>
                    <?php foreach ($tickets as $row): ?>
                        <?php $this->renderPost($row); ?>
                    <?php endforeach; ?>
                </div>
            </section>
        </main>
        <?php
        (new Layout('Post', ob_get_clean()))->show();
    }



    /**
     * Renders a single ticket along with its comments.
     *
     * @param array $ticket    Associative array containing ticket details.
     * @param array $comments  Array of associative arrays containing comments details.
     */
    public function renderSingleTicket(array $ticket, array $comments): void {
        $ticketTitle = htmlspecialchars($ticket['title']);
        $ticketMessage = htmlspecialchars($ticket['message']);
        $ticketUsername = htmlspecialchars($ticket['username']);
        $ticketDate = htmlspecialchars($ticket['date']);
        $ticketId = htmlspecialchars($ticket['ticket_id']);
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>View Ticket</title>
        </head>
        <body>
        <div>
            <h1><?= $ticketTitle ?></h1>
            <p><?= $ticketMessage ?></p>
            <p><strong>Auteur :</strong> <?= $ticketUsername ?></p>
            <p><strong>Date :</strong> <?= $ticketDate ?></p>
            <h2>Commentaires</h2>
            <form method="post" action="/pages/view-ticket?ticket_id=<?= $ticketId ?>">
                <textarea name="comment" required></textarea><br>
                <input type="submit" value="Poster le Commentaire">
            </form>
            <?php foreach ($comments as $comment):
                $commentText = htmlspecialchars($comment['text']);
                $commentDate = htmlspecialchars($comment['date']);
                $commentLikeCount = htmlspecialchars($comment['like_count']);
                $commentId = htmlspecialchars($comment['comment_id']);
                ?>
                <div>
                    <p><?= $commentText ?></p>
                    <p><strong>Date :</strong> <?= $commentDate ?></p>
                    <p><strong>Likes :</strong> <?= $commentLikeCount ?></p>
                    <a href="/pages/like-comment?comment_id=<?= $commentId ?>">Like</a>
                </div>
            <?php endforeach; ?>
        </div>
        </body>
        </html>
        <?php
    }
}
