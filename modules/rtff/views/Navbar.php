<?php
namespace rtff\views;

class Navbar
{
    /**
     * Displays appropriate user options based on login status.
     */
    private function displayConnected(): void {
        if (isset($_SESSION['account_id'])) {
            // User is logged in: Display the logout button
            echo '<button class="classic-button" onclick="location.href=\'/authentication/logout\'">Logout</button>';
        } else {
            // User is not logged in: Display the login button
            echo '<button class="classic-button" onclick="location.href=\'/authentication\'">Login</button>';
        }
    }

    /**
     * Displays the navigation bar with user options based on the session's login status.
     */
    public function show(): void {
        ?>
        <!-- Link to the stylesheet for the navigation bar -->
        <link rel="stylesheet" href="/assets/styles/navbar.css">

        <!-- Navigation bar structure -->
        <nav class="navbar">
            <!-- Left element: Logo -->
            <div class="navbar-element navbar-left-element">
                <a href="/">
                    <img id="logo" src="/assets/images/logo.png" alt="logo">
                </a>
            </div>

            <!-- Center element: Title -->
            <div class="navbar-element navbar-center-element" id="title">
                Read The F****** Forum
            </div>

            <!-- Right element: User options -->
            <div class="navbar-element navbar-right-element" id="options">
                <?php $this->displayConnected(); ?>
            </div>
        </nav>
        <?php
    }


}

