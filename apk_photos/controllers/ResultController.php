<?php
require_once('models/resultat_crud.php');
require_once('models/Etudiant.php');

function afficher_top3_resultats() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['id'])) {
        die("Vous devez être connecté pour voir les résultats.");
    }

    $etudiantConnecte = recuperer_etudiant_par_id($_SESSION['id']);
    if (!etudiant_est_administrateur($etudiantConnecte)) {
        $titrePage = 'Phase de résultats';
        $messagePage = 'Renenez prochainement.';
        require('views/concours_non_accessible_view.php');
        return;
    }

    // Les administrateurs peuvent voir les résultats même si la date officielle n'est pas encore ouverte.
    $photosTop3 = recuperer_top3_photos_tour2();
    require('views/resultats_view.php');
}
