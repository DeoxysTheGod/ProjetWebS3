<?php
namespace rtff\controllers\pages;

use rtff\database\DatabaseConnexion;
use rtff\models\CategoryModel;
use rtff\models\TicketModel;

require_once 'modules/rtff/views/Homepage.php';

class Homepage
{
    /**
     * @var TicketModel Le modèle pour les tickets.
     */
    private TicketModel $ticketModel;
    /**
     * @var CategoryModel Le modèle pour les catégories.
     */
	private CategoryModel $categoryModel;
    /**
     * Constructeur de la classe.
     */
    public function __construct() {
        $database = DatabaseConnexion::getInstance();
        $db = $database->getConnection();
        $this->ticketModel = new TicketModel($db);
		$this->categoryModel = new CategoryModel($db);
    }
    /**
     * Affiche la page d'accueil.
     *
     * Cette méthode récupère les derniers cinq tickets et les catégories triées par utilisation,
     * puis affiche la page d'accueil en utilisant la vue associée.
     */
    public function defaultMethod() {
        $tickets = $this->ticketModel->getLastFiveTickets();
		$categories = $this->categoryModel->getCategoriesSortedByUsage();
        (new \rtff\views\Homepage())->show($tickets, $categories);
    }

}