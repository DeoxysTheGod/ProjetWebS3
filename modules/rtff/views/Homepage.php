<?php
namespace rtff\views;

class Homepage
{
    public function show(array $tickets): void
    {
        ob_start();
        $navbar = new Navbar();
        $navbar->show();
        ?>
        <main>
            <section id="content">
                <h1>Derniers Tickets</h1>
                <?php foreach ($tickets as $ticket): ?>
                    <div class="ticket">
                        <h2><?= htmlspecialchars($ticket['title'] ?? '') ?></h2>
                        <p><?= htmlspecialchars($ticket['message'] ?? '') ?></p>
                        <p><em>Par <?= htmlspecialchars($ticket['username'] ?? '') ?> le <?= htmlspecialchars($ticket['date'] ?? '') ?></em></p>
                        <?php if (!empty($ticket['image_path'])): ?>
                            <img src="<?= htmlspecialchars($ticket['image_path'] ?? '') ?>" alt="Image du ticket">
                        <?php endif; ?>
                        <a href="/pages/view-ticket?ticket_id=<?= htmlspecialchars($ticket['ticket_id'] ?? '') ?>" style='padding: 10px; background-color: blue; color: white; text-decoration: none; border-radius: 5px;'>Répondre</a>

                    </div>
                <?php endforeach; ?>
            </section>

            <section id="options">
                <h1>Mettre ici les options de l'utilisateur</h1>
            </section>

            <section>
                <a class='connection' href='/post/view-posts'>Connexion</a>

            </section>
        </main>
        <?php
        (new Layout('Home', ob_get_clean()))->show();
    }
}
