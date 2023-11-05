<?php
namespace rtff\views;

class Navbar
{
    private function displayConnected(): void
	{
        if (isset($_SESSION['account_id'])) {
            // Si l'utilisateur est connecté, affichez le bouton de déconnexion
            ?><button class="classic-button" onclick="location.href='/authentication/logout'">Déconnexion</button>
            <?php
        } else {
            // Si l'utilisateur n'est pas connecté, affichez le bouton de connexion
            ?>
            <button class="classic-button" onclick="location.href='/authentication'">Connexion</button>
            <?php
        }
    }

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
                <?= $this->displayConnected(); ?>
            </div>
        </nav>
        <?php
    }
}

