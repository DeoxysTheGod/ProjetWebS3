<?php

// modules/rtff/controllers/pages/TicketController.php
namespace rtff\controllers\pages;

use rtff\database\DatabaseConnexion;
use rtff\models\TicketModel;
use rtff\views\TicketView;

class TicketController {
    private $model;
    private $view;
    private $db;

    public function __construct() {
        $database = DatabaseConnexion::getInstance();
        $this->db = $database->getConnection();
        $this->model = new TicketModel($this->db);
        $this->view = new TicketView();
    }


    public function listTickets() {
        session_start();

        $tickets = $this->model->getAllTickets();

        $this->view->render($tickets);
    }

    public function listLastFiveTickets() {
        session_start();
        $tickets = $this->model->getLastFiveTickets();
        $this->view->render($tickets);
    }


    public function createPost() {
        session_start();
        if (!isset($_SESSION['account_id'])) {
            header('Location: /authentication');
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST['title'];
            $message = $_POST['message'];
            $author = $_SESSION['account_id'];
            $imagePath = '';

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $uploadsDir = 'uploads/';
                $uploadedFile = $uploadsDir . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFile);
                $imagePath = $uploadedFile;
            }

            $this->model->addPost($title, $message, $author, $imagePath);
            if (!empty($_POST['categories'])) {
                $ticketId = $this->db->lastInsertId();
                foreach ($_POST['categories'] as $categoryId) {
                    $this->model->addTicketCategory($ticketId, $categoryId);
                }
            }

            header('Location: /post/view-posts');
            exit;
        }

        $this->view->show();
    }


    public function viewTicket() {
        session_start();
        if (!isset($_SESSION['account_id'])) {
            header('Location: /authentication');
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
