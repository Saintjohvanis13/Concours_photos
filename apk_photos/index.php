<?php
// On affiche les erreurs utiles pendant le développement.
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
ini_set('display_errors', 1);

// On démarre la session pour garder les informations de connexion.
session_start();

// On récupère la page demandée dans l'URL.
// Exemple : index.php?req=vote ouvre la page de vote.
// Si rien n'est demandé, on affiche la page de connexion.
$page = $_GET['req'] ?? 'login';

// Le routeur choisit quel fichier lancer selon la page demandée.
switch ($page) {
    case 'login':
        require 'controllers/AuthController.php';
        break;

    case 'accueil':
        require 'views/accueil_view.php';
        break;

    case 'depot':
        require 'controllers/mettre_photo_controller.php';
        break;

    case 'vote':
        require 'controllers/VoteController.php';
        ctrl_vote();
        break;

    case 'resultat':
        require 'controllers/ResultController.php';
        afficher_top3_resultats();
        break;

    case 'admin':
        require 'controllers/AdminController.php';
        ctrl_admin();
        break;

    case 'modifier_photos':
        require 'controllers/AdminPhotosController.php';
        ctrl_modifier_photos();
        break;

    case 'utilisateurs_admin':
        require 'controllers/AdminUtilisateursController.php';
        ctrl_utilisateurs_admin();
        break;

    case 'logout':
        require 'controllers/LogoutController.php';
        deconnexion();
        break;

    default:
        require 'views/404.php';
        break;
}
