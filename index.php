<?php
require_once './modules/rtff/Autoloader.php';
rtff\Autoloader::register();

try
{
	(new rtff\controllers\HomepageController())->execute();
} catch (Exception $e) {

}