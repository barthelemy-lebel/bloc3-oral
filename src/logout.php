<?php
// Démarre la session si elle n'est pas déjà démarrée
session_start();

// Détruit toutes les données de session
$_SESSION = array();

// Si vous voulez détruire complètement la session, effacez également le cookie de session.
// Notez bien : cela détruira la session et pas seulement les données de session !
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Détruit la session actuelle
session_destroy();

// Redirige l'utilisateur vers la page de connexion
header("Location: login.php");
exit;