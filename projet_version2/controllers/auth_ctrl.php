<?php
require_once __DIR__ . '/../models/auth.php';

function connexion_ctrl() {
    $erreur = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = trim($_POST['login'] ?? '');
        $pass = $_POST['pass'] ?? '';

        if ($login === '' || $pass === '') {
            $erreur = 'Veuillez remplir l’identifiant et le mot de passe.';
        } else {
            $resultat = connecter_utilisateur($login, $pass);

            if ($resultat === true) {
                header('Location: index.php?route=espace');
                exit;
            }

            if ($resultat === 'bloque') {
                $erreur = 'Votre compte est bloqué.';
            } else {
                $erreur = 'Identifiant ou mot de passe incorrect.';
            }
        }
    }

    require __DIR__ . '/../views/login.php';
}

function deconnexion_ctrl() {
    deconnecter_utilisateur();
    header('Location: index.php?route=accueil');
    exit;
}

function obliger_connexion() {
    if (!est_connecte()) {
        header('Location: index.php?route=connexion');
        exit;
    }
}

function obliger_admin() {
    obliger_connexion();
    if (!est_admin()) {
        header('Location: index.php?route=espace');
        exit;
    }
}
