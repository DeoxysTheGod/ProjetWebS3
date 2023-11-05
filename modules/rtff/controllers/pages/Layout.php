<?php
namespace rtff\controllers\pages;

require_once 'modules/rtff/views/Homepage.php';
require_once 'modules/rtff/views/Layout.php';

class Layout
{
    /**
     * Exécute l'action par défaut du contrôleur.
     *
     * Cette méthode affiche le layout principal du site (avec le titre "RT*F") sans contenu spécifique.
     */
    public function execute(): void
    {
        (new \rtff\views\Layout('RT*F', null))->show();
    }
}