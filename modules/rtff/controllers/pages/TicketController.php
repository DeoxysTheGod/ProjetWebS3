<?php

namespace rtff\controllers\pages;

use rtff\models\TicketModel;
use rtff\views\TicketView;

// controllers/TicketController.php
class TicketController {
    private $model;
    private $view;

    public function __construct($model, $view) {
        $this->model = $model;
        $this->view = $view;
    }

    public function listTickets() {
        $tickets = $this->model->getAllTickets();
        $this->view->render($tickets);
    }
}
