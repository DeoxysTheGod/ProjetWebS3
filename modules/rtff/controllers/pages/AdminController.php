<?php

namespace rtff\controllers\pages;

class AdminController {
    private $model;
    private $view;

    public function __construct($model, $view) {
        $this->model = $model;
        $this->view = $view;
    }

    public function manageCategories() {
        // Récupère toutes les catégories pour les afficher dans la vue
        $categories = $this->model->getAllCategories();
        $this->view->showCategories($categories);
    }

    public function createCategory() {
        // Crée une nouvelle catégorie
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $this->model->addCategory($title, $description);
            header('Location: /admin/categories');
            exit;
        }
    }
    public function deleteCategory() {
        $categoryId = $_GET['id'];
        $this->model->deleteCategory($categoryId);
        header('Location: /admin/manage-categories');
        exit;
    }

}
