<?php

    namespace rtff\views;
class Layout
{
    public function __construct(private string $title, private string $content) {}
    public function show(): void
    {
?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <title><?= $this->title; ?></title>
    <link rel="stylesheet" href="/assets/styles/style.css"/>
</head>
<body>
<?= $this->content; ?>
</body>
</html>
<?php
    }
}