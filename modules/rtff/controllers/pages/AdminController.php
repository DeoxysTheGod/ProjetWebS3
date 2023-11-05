<?php

namespace rtff\controllers\pages;

use JetBrains\PhpStorm\NoReturn;

class AdminController {
    private $model;
    private $view;

    public function __construct($model, $view) {
        $this->model = $model;
        $this->view = $view;
    }
    /**
     * Vérifie si l'utilisateur est un administrateur.
     *
     * @return bool Vrai si l'utilisateur est un administrateur, sinon faux.
     */
    private function isAdmin(): bool {
        session_start();
        return $_SESSION['admin'] == 1;
    }
    /**
     * Redirige l'utilisateur vers la page d'erreur.
     */
    #[NoReturn] private function redirectToErrorPage(): void
    {
        header('Location: /error');
        exit;
    }

    /**
     * Affiche toutes les catégories.
     */
    public function manageCategories(): void
    {
        if (!$this->isAdmin()) {
            $this->redirectToErrorPage();
        }

        // Récupère toutes les catégories pour les afficher dans la vue
        $categories = $this->model->getAllCategories();
        $this->view->showCategories($categories);
    }
    /**
     * Crée une nouvelle catégorie.
     */
    public function createCategory(): void
    {
        if (!$this->isAdmin()) {
            $this->redirectToErrorPage();
        }

        // Crée une nouvelle catégorie
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $this->model->addCategory($title, $description);
            header('Location: /admin/categories');
            exit;
        }
    }
        /**
         * Supprime une catégorie.
         */
    #[NoReturn] public function deleteCategory(): void
    {
        if (!$this->isAdmin()) {
            $this->redirectToErrorPage();
        }

        $categoryId = $_GET['id'];
        $this->model->deleteCategory($categoryId);
        header('Location: /admin/categories');
        exit;
    }

    #[NoReturn] public function deleteUser(): void
    {
        if (!$this->isAdmin()) {
            $this->redirectToErrorPage();
        }

        if (isset($_GET['id'])) {
            $this->model->deleteUser($_GET['id']);
        }
        header('Location: /admin/manage-users');
        exit;
    }

    #[NoReturn] public function deleteComment(): void
    {
        if (!$this->isAdmin()) {
            $this->redirectToErrorPage();
        }

        if (isset($_GET['id'])) {
            $this->model->deleteComment($_GET['id']);
        }
        header('Location: /admin/manage-comments');
        exit;
    }
    public function managePosts(): void
    {
        if (!$this->isAdmin()) {
            $this->redirectToErrorPage();
        }

        // Récupère tous les posts pour les afficher dans la vue
        $posts = $this->model->getAllPosts();
        $this->view->showPosts($posts);
    }

    #[NoReturn] public function deletePost(): void
    {
        if (!$this->isAdmin()) {
            $this->redirectToErrorPage();
        }

        // Supprime un post
        if (isset($_GET['id'])) {
            $this->model->deletePost($_GET['id']);
        }
        header('Location: /admin/manage-posts');
        exit;
    }

    public function manageUsers(): void
    {
        if (!$this->isAdmin()) {
            $this->redirectToErrorPage();
        }

        $users = $this->model->getAllUsers();
        $this->view->showUsers($users);
    }
    /**
     * Affiche tous les commentaires.
     */
    public function manageComments() {
        if (!$this->isAdmin()) {
            $this->redirectToErrorPage();
        }

        $comments = $this->model->getAllComments();
        $this->view->showComments($comments);
    }

}
