<?php

namespace rtff\views;

/**
 * Layout Class
 *
 * Provides methods to render the main layout of the application.
 */
class Layout
{
    private Navbar $navbar;

    /**
     * Constructor initializes the layout with a title and content.
     *
     * @param string $title   The title of the page.
     * @param string $content The content of the page.
     */
    public function __construct(private string $title, private string $content) {
        $this->navbar = new Navbar();
    }

    /**
     * Renders the layout of the page.
     */
    public function show(): void
    {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="utf-8"/>
            <title><?= $this->title; ?></title>
            <link rel="icon" type="image/x-icon" href="/assets/images/icons/favicon-white/favicon.ico">
            <link rel="stylesheet" href="/assets/styles/style.css"/>
            <link rel="stylesheet" href="/assets/styles/navbar.css">
        </head>
        <body>
        <header>
            <?php $this->navbar->show(); ?>
        </header>
        <div id="content-page">
            <?= $this->content; ?>
        </div>
        </body>
        </html>
        <?php
    }
}
