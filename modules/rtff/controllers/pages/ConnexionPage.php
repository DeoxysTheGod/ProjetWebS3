<?php
namespace rtff\controllers\pages;

require_once 'modules/rtff/views/ConnexionPage.php';

use Includes\Database\DatabaseConnexion;

class ConnexionPage
{
    public function execute(): void
    {
        (new \rtff\views\ConnexionPage())->show();
    }
}