<?php
require_once './modules/rtff/Autoloader.php';
rtff\Autoloader::register();

try
{
    (new rtff\views\CreateUserPage())->show();
} catch (Exception $e) {

}