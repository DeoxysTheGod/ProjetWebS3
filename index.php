<?php
// index.php
require_once './modules/rtff/Autoloader.php';
\rtff\Autoloader::register();

// Découpage de l'URL
$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($urlPath, '/'));
$controllerSegment = $segments[0] ?? 'authentication';
$actionSegment = $segments[1] ?? 'ConnectUser';
$methodSegment = $segments[2] ?? 'defaultMethod';

// Construction du chemin vers le fichier du contrôleur et du nom de la classe contrôleur
$controllerFile = "./modules/rtff/controllers/$controllerSegment/$actionSegment.php";
$controllerClass = "\\rtff\\controllers\\$controllerSegment\\$actionSegment";

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    if (class_exists($controllerClass)) {
        $controllerObject = new $controllerClass();
        if (method_exists($controllerObject, $methodSegment)) {
            $controllerObject->$methodSegment();
        } else {
            http_response_code(404);
            echo "Méthode $methodSegment non trouvée.";
        }
    } else {
        http_response_code(404);
        echo "Classe contrôleur $controllerClass non trouvée.";
    }
} else {
    http_response_code(404);
    echo "Fichier du contrôleur $controllerFile non trouvé.";
}
