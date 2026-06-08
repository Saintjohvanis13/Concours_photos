<?php
/**
 * Front controller du concours photo
 * Même principe que les exemples de TP : index.php?route=...
 */
session_start();

error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
ini_set('display_errors', 1);

$route = null;
if (isset($_GET['route'])) {
    $route = 'invalid';
    if (preg_match('#^[a-zA-Z0-9_]*$#', $_GET['route'])) {
        $route = $_GET['route'];
    }
}
if (isset($_POST['route'])) {
    $route = $_POST['route'];
}

switch ($route) {
    case null:
    case '':
    case 'accueil':
        require 'controllers/page_ctrl.php';
        accueil_ctrl();
        break;

    case 'connexion':
        require 'controllers/auth_ctrl.php';
        connexion_ctrl();
        break;

    case 'deconnexion':
        require 'controllers/auth_ctrl.php';
        deconnexion_ctrl();
        break;

    case 'espace':
        require 'controllers/page_ctrl.php';
        espace_ctrl();
        break;

    case 'depot_photo':
        require 'controllers/photo_ctrl.php';
        depot_photo_ctrl();
        break;

    case 'mes_photos':
        require 'controllers/photo_ctrl.php';
        mes_photos_ctrl();
        break;

    case 'supprimer_photo':
        require 'controllers/photo_ctrl.php';
        supprimer_photo_ctrl();
        break;

    case 'vote':
        require 'controllers/vote_ctrl.php';
        vote_ctrl();
        break;

    case 'mes_votes':
        require 'controllers/vote_ctrl.php';
        mes_votes_ctrl();
        break;

    case 'admin':
        require 'controllers/admin_ctrl.php';
        admin_ctrl();
        break;

    case 'admin_accueil':
        require 'controllers/admin_ctrl.php';
        admin_accueil_ctrl();
        break;

    case 'admin_dates':
        require 'controllers/admin_ctrl.php';
        admin_dates_ctrl();
        break;

    case 'admin_photos':
        require 'controllers/admin_ctrl.php';
        admin_photos_ctrl();
        break;

    case 'admin_bloquer':
        require 'controllers/admin_ctrl.php';
        admin_bloquer_ctrl();
        break;

    case 'resultats':
        require 'controllers/admin_ctrl.php';
        resultats_ctrl();
        break;

    default:
        require 'views/404.php';
        break;
}
