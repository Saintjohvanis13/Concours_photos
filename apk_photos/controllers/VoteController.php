<?php
function ctrl_vote() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['id'])) {
        die("Vous devez être connecté pour voter.");
    }

    require('models/connection.php');
    require_once('models/Etudiant.php');
    require('models/Vote_crud.php');

    $etudiantId = $_SESSION['id'];
    $etudiant = recuperer_etudiant_par_id($etudiantId);

    if (!$etudiant) {
        die("Étudiant introuvable en base.");
    }

    if (!etudiant_est_administrateur($etudiant)) {
        $titrePage = 'Phase de vote';
        $messagePage = 'Revenez prochainement.';
        require('views/concours_non_accessible_view.php');
        return;
    }

    $login = $etudiant['login'] ?? '';
    $idUtilisateur = $etudiantId;

    $error = '';
    $phase = 0;

    $pdo = connexion_base_de_donnees();
    $now = date('Y-m-d');
    $vote1_start = recuperer_date_debut_vote1($pdo);
    $vote1_end = recuperer_date_fin_vote1($pdo);
    $vote2_start = recuperer_date_debut_vote2($pdo);
    $vote2_end = recuperer_date_fin_vote2($pdo);

    if ($now >= $vote1_start && $now <= $vote1_end) {
        $phase = 1;
    } elseif ($now >= $vote2_start && $now <= $vote2_end) {
        $phase = 2;
    }

    if ($phase === 0) {
        $phase = 1;
    }

    if ($phase === 1) {
        $photoIds = recuperer_ids_photos_depuis_dossier();
        $voteCount = compter_votes($pdo, $idUtilisateur, 1);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vote'], $_POST['vote_id'])) {
            $voteId = $_POST['vote_id'];

            if (!in_array($voteId, $photoIds)) {
                $error = "Photo invalide sélectionnée.";
            } elseif ($voteCount >= 3) {
                $error = "Vous avez déjà utilisé vos 3 votes.";
            } elseif (a_deja_vote_pour_photo($pdo, $idUtilisateur, $voteId, 1)) {
                $error = "Vous avez déjà voté pour cette photo.";
            } else {
                enregistrer_vote($pdo, $idUtilisateur, 1, $voteId);
                header("Location: " . $_SERVER['REQUEST_URI']);
                exit;
            }
        }

    } elseif ($phase === 2) {
        $top = recuperer_top3_photos($pdo);
        $photoIds = [];

        foreach ($top as $photo) {
            $id = $photo['id_photo'];
            if (file_exists("photos/$id.jpg")) {
                $photoIds[] = $id;
            }
        }

        $voteCount = compter_votes($pdo, $idUtilisateur, 2);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vote'], $_POST['vote_id'])) {
            $voteId = $_POST['vote_id'];

            if ($voteCount > 0) {
                $error = "Vous avez déjà voté.";
            } elseif (!in_array($voteId, $photoIds)) {
                $error = "Photo invalide.";
            } else {
                enregistrer_vote($pdo, $idUtilisateur, 2, $voteId);
                header("Location: " . $_SERVER['REQUEST_URI']);
                exit;
            }
        }
    }

    require('views/vote_view.php');
}
