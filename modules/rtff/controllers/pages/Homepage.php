<?php
namespace rtff\controllers\pages;

use rtff\database\DatabaseConnexion;
use rtff\models\CategoryModel;
use rtff\models\TicketModel;

require_once 'modules/rtff/views/Homepage.php';

class Homepage
{
    private TicketModel $ticketModel;
	private CategoryModel $categoryModel;

    public function __construct() {
        $database = DatabaseConnexion::getInstance();
        $db = $database->getConnection();
        $this->ticketModel = new TicketModel($db);
		$this->categoryModel = new CategoryModel($db);
    }

    public function defaultMethod() {
        $tickets = $this->ticketModel->getLastFiveTickets();
		$categories = $this->categoryModel->getCategoriesSortedByUsage();
        (new \rtff\views\Homepage())->show($tickets, $categories);
    }

}