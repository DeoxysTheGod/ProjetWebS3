<?php
require_once './modules/rtff/Autoloader.php';
rtff\Autoloader::register();

try
{
    (new rtff\views\Homepage())->show();
} catch (Exception $e) {

}