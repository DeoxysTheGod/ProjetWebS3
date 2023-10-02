<?php
// index.php
require_once './modules/rtff/Autoloader.php';
\rtff\Autoloader::register();

$controller = $_GET['controller'] ?? 'defaultController';
$action = $_GET['action'] ?? 'defaultAction';

$controllerClassName = "\\rtff\\controllers\\" . ucfirst($controller) . "Controller";
if(class_exists($controllerClassName)) {
    $controllerObject = new $controllerClassName();
    if(method_exists($controllerObject, $action)) {
        $controllerObject->$action();
    } else {
        http_response_code(404);
        echo "404 Not Found - Action non trouvée";
    }
} else {
    http_response_code(404);
    echo "404 Not Found - Contrôleur non trouvé";
}
