<?php
    namespace Rtff\View;

    class Navbar
    {
        public function show(): void
        {
            ob_start();
            ?>
            <nav>
                <a href="/">
                    <div id="logo">
                        <img src="../../../assets/images/logo-test.png" alt="logo">
                    </div id="logo">
                </a>

                <div id="title">
                    Read The * Forum
                </div>

                <div id="options">
                    <button>Sign in</button>
                    <button>Sign up</button>
                </div>
            </nav>
            <?php
        }
    }