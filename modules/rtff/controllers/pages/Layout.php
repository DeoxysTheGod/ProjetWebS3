<?php
namespace rtff\controllers\pages;

require_once 'modules/rtff/views/Homepage.php';
require_once 'modules/rtff/views/Layout.php';

class Layout
{
    public function execute(): void
    {
        (new \rtff\views\Layout('RT*F', null))->show();
    }
}