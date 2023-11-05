<?php

// modules/rtff/controllers/pages/TicketController.php
namespace rtff\controllers\pages;

use rtff\models\TicketModel;
use rtff\views\TicketView;

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

    public function viewTicket() {
        session_start();
        if (!isset($_SESSION['account_id'])) {
            header('Location:   /authentication');
            exit;
        }

        $ticket_id = isset($_GET['ticket_id']) ? $_GET['ticket_id'] : null;
        if (!$ticket_id) {
            header('Location: error.php');
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
            $this->model->addComment($_POST['comment'], $_SESSION['account_id'], $ticket_id);
        }

        $ticket = $this->model->getTicket($ticket_id);
        $comments = $this->model->getComments($ticket_id);

        $this->view->renderSingleTicket($ticket, $comments);
    }
}
