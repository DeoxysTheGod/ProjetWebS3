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
        header('Location: /admin/categories');
        exit;
    }

    public function deleteUser() {
        if (isset($_GET['id'])) {
            $this->model->deleteUser($_GET['id']);
        }
        header('Location: /admin/manage-users');
        exit;
    }

    public function deleteComment() {
        if (isset($_GET['id'])) {
            $this->model->deleteComment($_GET['id']);
        }
        header('Location: /admin/manage-comments');
        exit;
    }
    public function managePosts() {
        // Récupère tous les posts pour les afficher dans la vue
        $posts = $this->model->getAllPosts();
        $this->view->showPosts($posts);
    }

    public function deletePost() {
        // Supprime un post
        if (isset($_GET['id'])) {
            $this->model->deletePost($_GET['id']);
        }
        header('Location: /admin/manage-posts');
        exit;
    }

    public function manageUsers() {
        $users = $this->model->getAllUsers();
        $this->view->showUsers($users);
    }

    public function manageComments() {
        $comments = $this->model->getAllComments();
        $this->view->showComments($comments);
    }



}
