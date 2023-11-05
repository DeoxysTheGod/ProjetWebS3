<?php

require_once './modules/rtff/Autoloader.php';
rtff\Autoloader::register();

use rtff\controllers\pages\TicketController;
use rtff\models\TicketModel;
use rtff\views\TicketView;
use rtff\views\CreateUserPost;
use rtff\database\DatabaseConnexion;

$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($urlPath, '/'));
$routePath = implode('/', $segments);

$controllerSegment = $segments[0] ?? 'authentication';
$actionSegment = $segments[1] ?? 'ConnectUser';
$methodSegment = $segments[2] ?? 'defaultMethod';

$database = DatabaseConnexion::getInstance();
$db = $database->getConnection();
// Définition des routes

$routes = [
    '/' => function() {
        $database = DatabaseConnexion::getInstance();
        $db = $database->getConnection();
        $model = new TicketModel($db);
        $view = new TicketView();
        $controller = new TicketController($model, $view);
        $controller->listTickets();
    },
    'post/view-posts' => function() use ($db) {
        $model = new TicketModel($db);
        $view = new TicketView();
        $controller = new TicketController($model, $view);
        $controller->listTickets();
    },
    'post/create' => function() use ($db) {
        $model = new TicketModel($db);
        $view = new CreateUserPost();
        $controller = new TicketController($model, $view);
        $controller->createPost();
    },
    'pages/view-ticket' => function() use ($db) {
        $model = new TicketModel($db);
        $view = new TicketView();
        $controller = new TicketController($model, $view);
        $controller->viewTicket();
    },

];

// Recherche de la route
$routePath = empty($segments) ? '/' : $controllerSegment . '/' . $actionSegment;

echo "URL Path: $urlPath<br>";
echo "Route Path: $routePath<br>";

if (isset($routes[$routePath])) {
    $routes[$routePath]();
} elseif (empty($routePath) || $routePath === '/') {
    $routes['/']();
} else {
    http_response_code(404);
    echo "Page non trouvée";
}
