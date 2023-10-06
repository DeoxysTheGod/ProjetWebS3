<?php
namespace rtff\controllers;

class HomepageController
{
	function execute(): void
	{
		(new \rtff\views\Homepage())->show();
	}
}