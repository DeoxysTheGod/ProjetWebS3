<?php

namespace rtff\controllers\pages;

use rtff\models\TicketModel;
use rtff\views\TicketView;

class TicketController {

    private $model;
    private $view;

    public function __construct() {
        $this->model = new TicketModel();
        $this->view = new TicketView();
    }

    public function listTickets() {
        $tickets = $this->model->getTicketsWithAuthor();
        $this->view->renderTickets($tickets);
    }
}
//
