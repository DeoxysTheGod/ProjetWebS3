<?php
// Code HTML pour afficher le message et le formulaire
if ($message != '') {
    echo "<p>$message</p>";
    if ($message === "Mot de passe modifié avec succès !") {
        echo '<p><html>
<head>
    <title>Connectez-vous</title>
</head>
<body>
<p>Cliquez sur le bouton ci-dessous pour vous connecter :</p>
<a href="https://rtff.alwaysdata.net/connectUser.php">Cliquez ici</a>
</body>
</html></p>';
    }
}

if (isset($token) && $message == '') {
    echo '<form method="post" action="modifyPasswordUser.php?token=' . $token . '">
        Nouveau Mot de Passe: <input type="password" name="new_password" required><br>
        <input type="submit" value="Modifier Mot de Passe">
    </form>';
}
?>
