<?php

require_once './modules/rtff/Autoloader.php';

rtff\Autoloader::register();

use rtff\controllers\authentication\ConnexionPage;

try
{
    (new ConnexionPage())->execute();
} catch (Exception $e) {

}