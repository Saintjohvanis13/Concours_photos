<?php
function ctrl_vote() {
    session_start();

    

    // Vérification de session
    if (!isset($_SESSION['id'])) {
        die("Vous devez être connecté pour voter.");
    }

	 require('models/connection.php');
    require_once('models/Etudiant.php');
    require('models/Vote_crud.php');
    
    $etudiantId = $_SESSION['id'];
    $etudiant = getEtudiantById($etudiantId);

    if (!$etudiant) {
        die("Étudiant introuvable en base.");
    }

    $login = $etudiant['login']; // ex: "CHEICK N'DIAYE"

    $userId = $etudiantId; // utilisé pour les votes

    $error = '';
    $phase = 0;

    // Détermination de la phase de vote
    $pdo = connection();
    $now = date('Y-m-d');
    $vote1_start = get_phase1_start_date($pdo);
    $vote1_end = get_phase1_end_date($pdo);
    $vote2_start = get_phase2_start_date($pdo);
    $vote2_end = get_phase2_end_date($pdo);

    if ($now >= $vote1_start && $now <= $vote1_end) {
        $phase = 1;
    } elseif ($now >= $vote2_start && $now <= $vote2_end) {
        $phase = 2;
    }

    if ($phase === 1) {
        $photoIds = get_photo_ids_from_directory();
        $voteCount = get_vote_count($pdo, $userId, 1);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vote'], $_POST['vote_id'])) {
            $voteId = $_POST['vote_id'];

            if (!in_array($voteId, $photoIds)) {
                $error = "Photo invalide sélectionnée.";
            } elseif ($voteCount >= 3) {
                $error = "Vous avez déjà utilisé vos 3 votes.";
            } elseif (has_already_voted_for_photo($pdo, $userId, $voteId, 1)) {
                $error = "Vous avez déjà voté pour cette photo.";
            } else {
                insert_vote($pdo, $userId, 1, $voteId);
                header("Location: " . $_SERVER['REQUEST_URI']);
                exit;
            }
        }

    } elseif ($phase === 2) {
        $top = get_top10_photos($pdo);
        $photoIds = [];

        foreach ($top as $photo) {
            $id = $photo['id_photo'];
            if (file_exists("photos/$id.jpg")) {
                $photoIds[] = $id;
            }
        }

        $voteCount = get_vote_count($pdo, $userId, 2);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vote'], $_POST['vote_id'])) {
            $voteId = $_POST['vote_id'];

            if ($voteCount > 0) {
                $error = "Vous avez déjà voté.";
            } elseif (!in_array($voteId, $photoIds)) {
                $error = "Photo invalide.";
            } else {
                insert_vote($pdo, $userId, 2, $voteId);
                header("Location: " . $_SERVER['REQUEST_URI']);
                exit;
            }
        }

    } else {
        $photoIds = []; // Hors période
    }

    // Passe aussi $login à la vue
    require('views/vote_view.php');
}
