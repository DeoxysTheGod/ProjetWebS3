<?php

namespace rtff\controllers;

use rtff\models\MailModel;
use rtff\views\MailView;

class MailController {

    private $model;
    private $view;
    public function __construct() {
        $this->model = new MailModel();
        $this->view = new MailView();
    }

    public function showForm(): void
    {
        $this->view->renderForm();
    }

    public function sendMail($account_id): void
    {
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
