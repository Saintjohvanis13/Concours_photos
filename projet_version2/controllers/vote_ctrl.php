<?php
require_once __DIR__ . '/../models/photo.php';
require_once __DIR__ . '/../models/vote.php';
require_once __DIR__ . '/auth_ctrl.php';

function vote_ctrl() {
    obliger_connexion();
    $message = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $choix = $_POST['photos'] ?? array();
        if (a_deja_vote($_SESSION['idUtilisateur'])) {
            $message = 'Vous avez déjà voté.';
        } elseif (count($choix) != 3) {
            $message = 'Vous devez choisir exactement 3 photos.';
        } else {
            enregistrer_votes($_SESSION['idUtilisateur'], $choix);
            $message = 'Vote enregistré.';
        }
    }

    $photos = toutes_photos_acceptees();
    require __DIR__ . '/../views/vote.php';
}

function mes_votes_ctrl() {
    obliger_connexion();
    $photos = votes_utilisateur($_SESSION['idUtilisateur']);
    require __DIR__ . '/../views/mes_votes.php';
}
