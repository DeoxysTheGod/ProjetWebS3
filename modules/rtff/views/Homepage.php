<?php
namespace rtff\views;

class Homepage
{

    /**
     * Displays the main view with the latest tickets and top categories.
     *
     * @param array $tickets    An array of the latest tickets.
     * @param array $categories An array of the top categories.
     */
    public function show(array $tickets, array $categories): void {
        ob_start();
        ?>
        <main id="container">
            <section id="history">
                <h1 class="side-panel-title">TBD</h1>
            </section>

            <section id="content">
                <h1>The 5 Latest Tickets</h1>
                <div id="ticket-container">
                    <?php for ($i = 0; $i < min(5, count($tickets)); $i++): ?>
                        <div class="ticket">
                            <h2 class="ticket-title"><?= htmlspecialchars($tickets[$i]['title'] ?? '') ?></h2>
                            <p><?= htmlspecialchars($tickets[$i]['message'] ?? '') ?></p>
                            <p><em>By <?= htmlspecialchars($tickets[$i]['username'] ?? '') ?> on <?= htmlspecialchars($tickets[$i]['date'] ?? '') ?></em></p>
                            <?php if (!empty($tickets[$i]['image_path'])): ?>
                                <img src="<?= htmlspecialchars($tickets[$i]['image_path']) ?>" alt="Ticket image">
                            <?php endif; ?>
                            <button class="classic-button" onclick="location.href = '/pages/view-ticket?ticket_id=<?= htmlspecialchars($tickets[$i]['ticket_id'] ?? '') ?>'">Reply</button>
                        </div>
                    <?php endfor; ?>
                </div>
                <button class='classic-button' onclick="location.href = '/post/view-posts'">View All</button>
            </section>

            <section id="top-categories">
                <h1 class="side-panel-title">Top Categories</h1>
                <ul>
                    <?php foreach ($categories as $category): ?>
                        <li><?= htmlspecialchars($category['title']); ?> - <?= $category['nb_usage']; ?></li>
                    <?php endforeach; ?>
                </ul>
            </section>
        </main>
        <?php
        (new Layout('Home', ob_get_clean()))->show();
    }
}
