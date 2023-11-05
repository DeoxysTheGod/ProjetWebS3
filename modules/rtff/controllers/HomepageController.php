<?php
namespace rtff\controllers;

class HomepageController
{
    /**
     * Exécute l'action par défaut du contrôleur.
     *
     * Cette méthode est responsable de l'exécution de l'action par défaut du contrôleur,
     * qui consiste à afficher la page d'accueil.
     */
	function execute(): void
	{
		(new \rtff\views\Homepage())->show();
	}
}