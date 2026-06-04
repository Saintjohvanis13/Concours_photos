<?php
session_start();
require_once __DIR__ . '/models/auth.php';

$erreur = '';
$action = $_GET['action'] ?? $_POST['action'] ?? '';

if ($action === 'deconnexion') {
    deconnecter_utilisateur();
    header('Location: index.php');
    exit;
}

if ($action === 'connexion' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $motDePasse = $_POST['mot_de_passe'] ?? '';

    $resultat = connecter_utilisateur($login, $motDePasse);

    if ($resultat === true) {
        header('Location: index.php');
        exit;
    }

    if ($resultat === 'bloque') {
        $erreur = 'Votre compte est bloqué. Veuillez contacter un administrateur.';
    } else {
        $erreur = 'Identifiant ou mot de passe incorrect.';
    }
}

if (est_connecte()) {
    require __DIR__ . '/vues/accueil.php';
} else {
    require __DIR__ . '/vues/login.php';
}
