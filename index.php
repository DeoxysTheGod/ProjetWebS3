<?php

require_once './modules/rtff/Autoloader.php';
rtff\Autoloader::register();

use rtff\controllers\authentication\ConnectUser;
use rtff\controllers\authentication\CreateUser;
use rtff\controllers\pages\AdminController;
use rtff\controllers\pages\Homepage;
use rtff\controllers\pages\MailController;
use rtff\controllers\pages\TicketController;
use rtff\models\AdminModel;
use rtff\models\CategoryModel;
use rtff\models\TicketModel;
use rtff\views\AdminView;
use rtff\views\TicketView;
use rtff\views\CreatePostView;
use rtff\database\DatabaseConnexion;
use rtff\controllers\authentication\LogoutController;

$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($urlPath, '/'));
$routePath = implode('/', $segments);
if ($routePath === '') {
    $routePath = '/';
}

$controllerSegment = $segments[0] ?? 'authentication';
$actionSegment = $segments[1] ?? 'ConnectUser';
$methodSegment = $segments[2] ?? 'defaultMethod';

$database = DatabaseConnexion::getInstance();
$db = $database->getConnection();

// Définition des routes
$routes = [
    '/' => function()  {
        $controller = new Homepage();
        $controller->defaultMethod();
    },
    'authentication' => function() {
        $controller = new ConnectUser();
        $controller->defaultMethod();
    },
    'authentication/create-user' => function() {
        $controller = new CreateUser();
        $controller->defaultMethod();
    },
    'authentication/reset-password' => function() {
        $controller = new MailController();
        $controller->showForm();
    },
    'post/view-posts' => function() use ($db) {
        $model = new TicketModel($db);
        $view = new TicketView();
        $controller = new TicketController($model, $view);
        $controller->listTickets();
    },
    'post/create' => function() use ($db) {
        $model = new TicketModel($db);
        $view = new CreatePostView($db);
        $controller = new TicketController($db);
        $controller->createPost();

    },
    'pages/view-ticket' => function() use ($db) {
        $model = new TicketModel($db);
        $view = new TicketView();
        $controller = new TicketController($model, $view);
        $controller->viewTicket();
    },
    'authentication/logout' => function() {
        $logoutController = new LogoutController();
        $logoutController->logout();
    },
    'admin/categories' => function() use ($db) {
        $model = new CategoryModel($db);
        $view = new AdminView();
        $controller = new AdminController($model, $view);
        $controller->manageCategories();
    },
    'admin/create-category' => function() use ($db) {
        $model = new CategoryModel($db);
        $view = new AdminView();
        $controller = new AdminController($model, $view);
        $controller->createCategory();
    },
    'admin/delete-category' => function() use ($db) {
        $model = new CategoryModel($db);
        $view = new AdminView();
        $controller = new AdminController($model, $view);
        $controller->deleteCategory();
    },
    'admin/manage-posts' => function() use ($db) {
        $model = new rtff\models\AdminModel($db);
        $view = new rtff\views\AdminView();
        $controller = new rtff\controllers\pages\AdminController($model, $view);
        $controller->managePosts();
    },
    'admin/delete-post' => function() use ($db) {
        $model = new rtff\models\AdminModel($db);
        $view = new rtff\views\AdminView();
        $controller = new rtff\controllers\pages\AdminController($model, $view);
        $controller->deletePost();
    },
    'admin/delete-user' => function() use ($db) {
        $model = new AdminModel($db);
        $view = new AdminView();
        $controller = new AdminController($model, $view);
        $controller->deleteUser();
    },
    'admin/delete-comment' => function() use ($db) {
        $model = new AdminModel($db);
        $view = new AdminView();
        $controller = new AdminController($model, $view);
        $controller->deleteComment();
    },


];

// Recherche de la route
if (isset($routes[$routePath])) {
    $routes[$routePath]();
} else {
    http_response_code(404);
    echo "Page non trouvée";
}