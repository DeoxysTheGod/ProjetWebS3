<?php
namespace rtff\views;

class Homepage
{
    public function show(array $tickets, array $categories): void
    {
        ob_start();
        ?>
        <main id="container">
            <section id="history">
                <h1 class="side-panel-title">On sait pas encore</h1>

            </section>
            <section id="content">
                <h1>Derniers Tickets</h1>
                <div id="ticket-container">
					<?php for ($i = 0; $i < 5; $i++): ?>
                        <div class="ticket">
                            <h2 class="ticket-title"><?= htmlspecialchars($tickets[$i]['title'] ?? '') ?></h2>
                            <p><?= htmlspecialchars($tickets[$i]['message'] ?? '') ?></p>
                            <p><em>Par <?= htmlspecialchars($tickets['username'] ?? '') ?> le <?= htmlspecialchars($tickets[$i]['date'] ?? '') ?></em></p>
							<?php if (!empty($tickets[$i]['image_path'])): ?>
                                <img src="<?= htmlspecialchars($tickets[$i]['image_path'] ?? '') ?>" alt="Image du ticket">
							<?php endif; ?>
                            <button class="classic-button" onclick="location.href = '/pages/view-ticket?ticket_id=<?= htmlspecialchars($tickets[$i]['ticket_id'] ?? '') ?>'">Répondre</button>
                        </div>
					<?php endfor; ?>
                </div>
            </section>

            <section id="top-categrories">
                <h1 class="side-panel-title">Top catégories</h1>
                <ul>
					<?php foreach ($categories as $category): ?>
                        <li><?= htmlspecialchars($category['title']);?></p></li>
					<?php endforeach;?>
                </ul>
            </section>
        </main>
        <?php
        (new Layout('Home', ob_get_clean()))->show();
    }
}
