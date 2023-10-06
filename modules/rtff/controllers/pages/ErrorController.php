<?php

// controllers/ErrorController.php

namespace rtff\controllers;

use rtff\views\Error404View;

class ErrorController {
    private $view;

    public function __construct() {
        $this->view = new Error404View();
    }

    public function showNotFoundPage() {
        // Chargez la vue pour afficher le résultat
        $view = new \rtff\views\PasswordResetView();
        $view->showNotFoundPage();
    }

    // Dans votre contrôleur lorsque la ressource n'est pas trouvée
    public function resourceNotFound() {
        // Définissez l'en-tête HTTP 404
        header("HTTP/1.0 404 Not Found");

        // Redirigez vers la page d'erreur 404
        header("Location: ../views/Error404View.php");
        exit;
    }

}
