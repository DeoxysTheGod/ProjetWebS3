<?php
require_once './navigation.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Votre Page</title>
</head>
<body>
<div style="margin-left:220px; padding:10px;">
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Formulaire d'Email</title>
    </head>
    <body>
        <form method="post" action="mail.php">
            Mail : <input name="account_id" type="email"/>
            <input name="send" type="submit"/>
        </form>
    </body>
    </html>
</div>
</body>
</html>
