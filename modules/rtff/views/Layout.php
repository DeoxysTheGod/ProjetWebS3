<?php

    namespace rtff\views;
class Layout
{
    private Navbar $navbar;
    public function __construct(private string $title, private string $content) {
        $this->navbar = new Navbar();
    }
    public function show(): void
    {
?><!DOCTYPE html>
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
	<?= $this->navbar->show() ?>
</header>
<div id="content-page">
	<?= $this->content; ?>
</div>
</body>
</html>
<?php
    }
}