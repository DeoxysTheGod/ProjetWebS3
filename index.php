<?php
require_once './modules/rtff/Autoloader.php';
rtff\Autoloader::register();

try {
    (new rtff\views\ConnexionPage())->show();
} catch (Exception $e) {

    header('./error404.php');
    exit;
}
