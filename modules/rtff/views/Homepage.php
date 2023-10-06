<?php
namespace rtff\views;

class Homepage
{
    public function show(): void
    {
        ob_start();
?><main>
    <section id="content">
        <h1>Mettre ici les post</h1>
    </section>

    <section id="options">
        <h1>Mettre ici les options de l'utilisateur</h1>
    </section>
</main>
    <?php
        (new \rtff\views\Layout('Home', ob_get_clean()))->show();
    }
}
