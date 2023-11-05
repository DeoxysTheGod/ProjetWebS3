<?php
namespace rtff\views;

class Navbar
{
    public function show(): void
    {
        ?>
        <link rel="stylesheet" href="/assets/styles/navbar.css">
        <nav class="navbar">
            <div class="navbar-element navbar-left-element">
                <a href="/">
                    <img id="logo" src="../../../assets/images/logo.png" alt="logo">
                </a>
            </div>


            <div class="navbar-element navbar-center-element" id="title">
                Read The F****** Forum
            </div>
            <div class="navbar-element navbar-right-element" id="options">
                <button>Sign in</button>
                <button>Sign up</button>
            </div>
        </nav>
        <?php
    }
}