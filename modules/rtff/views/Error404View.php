<?php

namespace rtff\views;

/**
 * Class Error404View
 *
 * Responsible for rendering the 404 Not Found error page.
 */
class Error404View {

    /**
     * Render the 404 Not Found error page.
     */
    public function showNotFoundPage(): void {
        ob_start();
        ?>

        <style>
            body {
                text-align: center;
            }
            a {
                text-decoration: none;
                color: #007BFF;
            }
        </style>

        <h1>Error 404</h1>
        <p>The page you are looking for cannot be found.</p>
        <p><a href="https://rtff.alwaysdata.net/">Back to Home</a></p>

        <?php
		(new \rtff\views\Layout('Erreur 404', ob_get_clean()))->show();
    }
}
