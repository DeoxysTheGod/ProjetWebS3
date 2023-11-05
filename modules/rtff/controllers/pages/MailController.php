<?php

namespace rtff\controllers\pages;

use rtff\models\MailModel;
use rtff\views\MailView;

class MailController {

    private $model; // Le modèle associé au contrôleur.
    private $view;  // La vue associée au contrôleur.

    /**
     * Constructeur de la classe MailController.
     * Initialise les objets modèle et vue.
     */
    public function __construct() {
        $this->model = new MailModel();
        $this->view = new MailView();
    }
    /**
     * Affiche le formulaire pour envoyer un e-mail.
     */
    public function showForm(): void
    {
        $this->view->renderForm();
    }
/**
 * Envoie un e-mail de réinitialisation de mot de passe.
 *
 * Récupère l'identifiant de compte depuis la requête POST et utilise le modèle pour envoyer l'e-mail.
 * Affiche la vue correspondante en fonction du résultat de l'envoi.
 */
    public function sendMail(): void
    {
        $account_id = $_POST['account_id'];
        $result = $this->model->sendPasswordReset($account_id);

        if ($result === true) {
            $this->view->renderSuccess();
        } elseif ($result === false) {
            $this->view->renderNoUser();
        } else {
            $this->view->renderError();
        }
    }
}
