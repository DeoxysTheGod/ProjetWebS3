<?php
namespace rtff\controllers\pages;

require_once 'modules/rtff/views/ConnexionPage.php';

use Includes\Database\DatabaseConnexion;

class ConnexionPage
{
    /**
     * Exécute l'action par défaut du contrôleur.
     *
     * Cette méthode affiche la page de connexion en utilisant la vue appropriée.
     */
    public function execute(): void
    {
        (new \rtff\views\ConnexionPage())->show();
    }
}