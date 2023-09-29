<?php

    namespace rtff\views;
class Layout
{
    public function __construct(private string $title, private string $content) {}
    public function show(): void
    {
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title><?= $this->title; ?></title>
    <link href="/assets/styles/style.css" rel="stylesheet"/>
</head>
<body>
<?= $this->content; ?>
</body>
</html>
<?php
    }
}