<?php
require_once './modules/rtff/Autoloader.php';
rtff\Autoloader::register();

try
{
    (new rtff\controllers\authentication\ConnexionPage())->execute();
} catch (Exception $e) {

}