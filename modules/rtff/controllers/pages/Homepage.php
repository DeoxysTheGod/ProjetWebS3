<?php
namespace rtff\controllers\pages;

require_once 'modules/rtff/views/Homepage.php';

class Homepage
{
    public function defaultMethod() {

        (new \rtff\views\Homepage())->show();
    }
}