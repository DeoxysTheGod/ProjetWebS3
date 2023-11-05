<?php
namespace rtff\controllers\pages;

use rtff\database\DatabaseConnexion;
use rtff\models\TicketModel;

require_once 'modules/rtff/views/Homepage.php';

class Homepage
{
    private $model;

    public function __construct() {
        $database = DatabaseConnexion::getInstance();
        $db = $database->getConnection();
        $this->model = new TicketModel($db);
    }

    public function defaultMethod() {
        $tickets = $this->model->getLastFiveTickets();
        (new \rtff\views\Homepage())->show($tickets);
    }

}