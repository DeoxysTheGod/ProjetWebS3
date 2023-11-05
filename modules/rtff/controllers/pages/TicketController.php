<?php

// modules/rtff/controllers/pages/TicketController.php
namespace rtff\controllers\pages;

use rtff\database\DatabaseConnexion;
use rtff\models\TicketModel;
use rtff\views\CreatePostView;
use rtff\views\TicketView;

class TicketController {
    private $model;
    private $view;
    private $db;

    public function __construct() {
        $database = DatabaseConnexion::getInstance();
        $this->db = $database->getConnection();
        $this->model = new TicketModel($this->db);
        $this->view = new TicketView($this->model);
    }

/**
 * Affiche la liste des tickets en fonction des catégories sélectionnées et/ou du terme de recherche.
 *
 * Cette méthode récupère les tickets en fonction des catégories sélectionnées et/ou du terme de recherche,
 * puis affiche ces tickets dans la vue TicketView.
 */
    public function listTickets() {
        session_start();

        $categoriesSelected = $_GET['categories'] ?? [];
        $searchTerm = $_GET['search'] ?? '';

        if (empty($categoriesSelected) && empty($searchTerm)) {
            // Si aucune catégorie n'est sélectionnée et aucun terme de recherche, récupérez tous les tickets
            $tickets = $this->model->getAllTickets();
        } else {
            // Sinon, récupérez les tickets des catégories sélectionnées et/ou correspondant au terme de recherche
            $tickets = $this->model->getTicketsByCategoriesAndSearch($categoriesSelected, $searchTerm);
        }

        $categories = $this->model->getAllCategories();
        $this->view->render($tickets, $categories);
    }

/**
 * Affiche les cinq derniers tickets.
 *
 * Cette méthode récupère les cinq derniers tickets et les affiche dans la vue TicketView.
 */
    public function listLastFiveTickets() {
        session_start();
        $tickets = $this->model->getLastFiveTickets();
        $this->view->render($tickets);
    }

/**
 * Crée un nouveau post.
 *
 * Cette méthode permet de créer un nouveau post en utilisant les données du formulaire
 * et de l'image téléchargée, puis redirige l'utilisateur vers la page de visualisation des posts.
 */
    public function createPost() {
        session_start();
        $this->view = new CreatePostView($this->db);

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

/**
 * Affiche un ticket spécifique.
 *
 * Cette méthode permet d'afficher un ticket spécifique en fonction de son identifiant (ticket_id).
 * Les commentaires associés au ticket sont également affichés.
 */
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
        $comments = $this->model->getCommentsWithLikes($ticket_id);

        $this->view->renderSingleTicket($ticket, $comments);
    }
}
