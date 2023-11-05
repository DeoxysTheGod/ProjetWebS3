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
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Error 404 - Page Not Found</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    text-align: center;
                    padding: 50px;
                }

                h1 {
                    font-size: 36px;
                    color: #333;
                }

                p {
                    font-size: 18px;
                    color: #777;
                }

                a {
                    text-decoration: none;
                    color: #007BFF;
                }
            </style>
        </head>
        <body>
        <h1>Error 404</h1>
        <p>The page you are looking for cannot be found.</p>
        <p><a href="https://rtff.alwaysdata.net/">Back to Home</a></p>
        </body>
        </html>
        <?php
    }
}
