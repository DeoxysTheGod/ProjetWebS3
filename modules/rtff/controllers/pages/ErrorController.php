<?php

// controllers/ErrorController.php

namespace rtff\controllers;

use rtff\views\Error404View;

class ErrorController {
    /**
     * @var Error404View La vue associée à ce contrôleur.
     */
    private $view;
    /**
     * Constructeur de la classe.
     */
    public function __construct() {
        $this->view = new Error404View();
    }
/**
 * Affiche la page d'erreur 404.
 *
 * Cette méthode charge la vue pour afficher la page d'erreur 404.
 */
    public function showNotFoundPage() {
        // Chargez la vue pour afficher le résultat
        $view = new \rtff\views\PasswordResetView();
        $view->showNotFoundPage();
    }
    /**
     * Gère une ressource non trouvée.
     *
     * Cette méthode définit l'en-tête HTTP 404 et redirige vers la page d'erreur 404.
     */
    public function resourceNotFound() {
        // Définisse l'en-tête HTTP 404
        header("HTTP/1.0 404 Not Found");

        // Redirige vers la page d'erreur 404
        header("Location: ../views/Error404View.php");
        exit;
    }

}
