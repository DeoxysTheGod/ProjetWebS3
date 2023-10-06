<?php
namespace rtff\controllers\pages;

class ConnexionPage
{
    public function execute(): void
    {
        (new \rtff\views\ConnexionPage())->show();
    }
}