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

    public function renderPost($row): void
    {
        $title = htmlspecialchars($row['title'] ?? 'Titre inconnu');
        $message = htmlspecialchars($row['message'] ?? 'Message inconnu');
        $username = htmlspecialchars($row['username'] ?? 'Auteur inconnu');
        $date = htmlspecialchars($row['date'] ?? 'Date inconnue');
        $imagePath = htmlspecialchars($row['image_path'] ?? '');
        $ticketId = htmlspecialchars($row['ticket_id'] ?? '');

        // Récupérer les catégories
        $categories = $this->model->getCategoriesForTicket($ticketId);
        $categoryNames = array_map(function($category) {
            return htmlspecialchars($category['title']);
        }, $categories);
        ?>
		<div class='ticket'>
			<h2><?= $title ?></h2>
			<?php
			if (!empty($categoryNames)) {
				?>
				<p><strong>Catégories :</strong><?= implode(', ', $categoryNames) ?></p>
				<?php
			}
			?>
			<p><?= $message ?></p>
			<?php

			if ($imagePath !== '') {
				?>
                <img class='image-post' src='/<?= $imagePath ?>' alt='Image associée'/>
				<?php
			}

			?>
			<p><strong>Auteur :</strong><?= $username ?></p>
			<p><strong>Date :</strong><?= $date ?></p>
        	<button class='classic-button' onclick="location.href = '/pages/view-ticket?ticket_id={$ticketId}'">Répondre</button>
        </div>
		<?php
    }


    public function render($tickets, $categories) {
		ob_start();

        // Formulaire pour filtrer les posts par catégories et rechercher des mots-clés
		?>
		<main id="container" class="view-post">
            <section id="history">
                <h1 class="side-panel-title">Filtre</h1>
                <form class='options' method='GET' action='/post/view-posts'>
                    <label for='categories'>Filtrer par catégorie:</label>
                    <select id='categories' name='categories[]' multiple>
                    <?php
                    foreach ($categories as $category) {
                        ?>
                        <option value="<?= htmlspecialchars($category['category_id']);?>"><?= htmlspecialchars($category['title']) ?></option>
                        <?php
                    }
                    // Champ de recherche
                    ?>
                    </select>
                    <input type='text' id='search' name='search' placeholder='Recherche...'>

                    <input type='submit' value='Filtrer/Rechercher'>
                </form>
            </section>

            <section id='content'>
                <h1>Tous les tickets</h1>
                <div id='ticket-container'>
                <?php
                foreach ($tickets as $row) {
                    $this->renderPost($row);
                }
                ?>
                </div>
            </section>
		</main>
		<?php

		(new \rtff\views\Layout('Post', ob_get_clean()))->show();
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
