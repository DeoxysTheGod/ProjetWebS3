<?php

namespace rtff\views;

class MailView {

    public function renderForm() {
        // Le contenu de votre formulaire
        echo '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Votre Page</title>
        </head>
        <body>
        <div style="margin-left:220px; padding:10px;">
            <form method="post" action="/pages/MailController/sendMail">
                Mail : <input name="account_id" type="email"/>
                <input name="send" type="submit"/>
            </form>
        </div>
        </body>
        </html>
        ';
    }

    public function renderSuccess() {
        echo "Mail envoyé avec succès.";
    }

    public function renderError() {
        echo "Un problème est survenu.";
    }

    public function renderNoUser() {
        echo "Aucun utilisateur trouvé avec cet email";
    }
}
