<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
ini_set('display_errors', 1);

session_start();

// Redirection par défaut vers la page de login si aucune route n'est fournie
$rte = $_GET['req'] ?? 'login';

// Liste des routes qui nécessitent une authentification
$routes_protegees = ['accueil', 'vote', 'admin', 'modifier_photos', 'utilisateurs_admin'];



// Gestion des routes
switch ($rte) {
    case 'accueil':
        require('views/accueil_view.php');
        break;

    case 'login':
        require("controllers/AuthController.php");
        break;

    case 'vote':
        require("controllers/VoteController.php");
        ctrl_vote();
        break;

    case 'admin':
        require("controllers/AdminController.php");
        ctrl_admin();
        break;

    case 'modifier_photos':
        require("controllers/AdminPhotosController.php");
        ctrl_modifier_photos();
        break;

    case 'utilisateurs_admin':
        require("controllers/AdminUtilisateursController.php");
        ctrl_utilisateurs_admin();
        break;


    case 'logout':
        require("controllers/LogoutController.php");
        deconnexion();
        break;
        
    case 'depot':
        require("controllers/mettre_photo_controller.php");
        break;
        
     case 'resultat':
     		require("controllers/ResultController.php");
     		afficher_top3_resultats();
     		break;

    default:
        require('views/404.php');
        break;
}

exit;
