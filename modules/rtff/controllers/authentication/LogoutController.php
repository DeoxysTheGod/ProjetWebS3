<?php
namespace rtff\controllers\authentication;

class LogoutController {

    /**
     * Déconnecte un utilisateur en détruisant sa session.
     *
     * Cette méthode se charge de déconnecter un utilisateur en détruisant sa session actuelle.
     * Si un utilisateur est connecté, sa session est effacée, et s'il utilise des cookies,
     * les cookies de session sont également supprimés.
     * Ensuite, l'utilisateur est redirigé vers la page d'authentification.
     */
    public function logout() {
        session_start();

        if (isset($_SESSION['account_id'])) {
            $_SESSION = array();

            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }

            session_destroy();
        }
        // Redirige l'utilisateur vers la page d'authentification
        header("Location: /authentication");
        exit;
    }
}