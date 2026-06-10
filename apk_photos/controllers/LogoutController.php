<?php
function deconnexion() {
    // On vide la session de l'utilisateur.
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    session_unset();
    session_destroy();

    // On revient sur la page de connexion.
    header("Location: index.php?req=login");
    exit;
}
