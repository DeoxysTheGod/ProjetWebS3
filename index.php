<?php
// index.php
require_once './modules/rtff/Autoloader.php';
\rtff\Autoloader::register();


(new rtff\views\ConnexionPage())->show();

//$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
//$segments = explode('/', trim($urlPath, '/'));
//$controllerSegment = isset($segments[0]) && $segments[0] != '' ? $segments[0] : 'authentication';
//$actionSegment = isset($segments[1]) && $segments[1] != '' ? $segments[1] : 'ConnectUser';
//
//$methodSegment = $segments[2] ?? 'defaultMethod';
//
//$controllerFile = "./modules/rtff/controllers/$controllerSegment/$actionSegment.php";
//$controllerClass = "\\rtff\\controllers\\$controllerSegment\\$actionSegment";
//
//if (file_exists($controllerFile)) {
//    require_once $controllerFile;
//    if (class_exists($controllerClass)) {
//        $controllerObject = new $controllerClass();
//        if (method_exists($controllerObject, $methodSegment)) {
//            $controllerObject->$methodSegment();
//        } else {
//            http_response_code(404);
//            echo "Méthode $methodSegment non trouvée.";
//        }
//    } else {
//        http_response_code(404);
//        echo "Classe contrôleur $controllerClass non trouvée.";
//    }
//} else {
//    http_response_code(404);
//    echo "Fichier du contrôleur $controllerFile non trouvé.";
//}
