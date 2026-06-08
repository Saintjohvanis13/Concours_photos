<?php
function afficherAccueil() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['login'])) {
        header("Location: /dev/concours_clone/public/index.php?page=login");
        exit;
    }

    include __DIR__ . '/../views/accueil_view.php';
}
