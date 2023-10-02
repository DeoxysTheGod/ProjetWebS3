<?php
require_once './modules/rtff/Autoloader.php';
\rtff\Autoloader::register();
$controller = $_GET['controller'] ?? './modules/rtff/controllers/authentication/ConnectUser.php';

// Vérifier si controller et action sont présents dans l'URL
if(isset($_GET['controller']) && isset($_GET['action'])) {
    // Récupérer le contrôleur et l'action à partir de l'URL
    $subdirectory = $_GET['subdirectory'] ?? '';
    $controller = $_GET['controller'];
    $action = $_GET['action'];

    // Construire le nom complet de la classe de contrôleur avec le sous-répertoire
    $controllerClassName = "\\rtff\\controllers\\" . ($subdirectory ? $subdirectory . '\\' : '') . ucfirst($controller);

    // Vérifier si la classe de contrôleur et la méthode (action) existent
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
} else {
    http_response_code(400);
    echo "400 Bad Request - Contrôleur ou action non spécifié dans l'URL";
}
