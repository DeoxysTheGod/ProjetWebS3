<?php
namespace rtff\views;

class Navbar
{
    public function show(): void
    {
        ?>
        <link rel="stylesheet" href="/assets/styles/navbar.css">
        <nav class="navbar">
            <a class="navbar-element navbar-left-element" href="/">
                <div id="logo">
                    <img src="../../../assets/images/logo.png" alt="logo">
                </div id="logo">
            </a>

            <div class="navbar-element navbar-center-element" id="title">
                Read The F****** Forum
            </div>
            <div class="navbar-element navbar-right-element" id="options">
                <button>Sign in</button>
                <button>Sign up</button>
            </div>
        </nav>
        <?php
        (new \rtff\views\Layout('Navigation', ob_get_clean()))->show();
    }
}