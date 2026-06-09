<?php
function recuperer_date_debut_vote1($pdo) {
    $stmt = $pdo->prepare("SELECT valeur FROM configuration WHERE parametre = 'vote1_debut'");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function recuperer_date_fin_vote1($pdo) {
    $stmt = $pdo->prepare("SELECT valeur FROM configuration WHERE parametre = 'vote1_fin'");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function recuperer_date_debut_vote2($pdo) {
    $stmt = $pdo->prepare("SELECT valeur FROM configuration WHERE parametre = 'vote2_debut'");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function recuperer_date_fin_vote2($pdo) {
    $stmt = $pdo->prepare("SELECT valeur FROM configuration WHERE parametre = 'vote2_fin'");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function compter_votes($pdo, $idUtilisateur, $phase) {
    $table = ($phase == 1) ? "vote1" : "vote2";
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM $table WHERE id_etu = ?");
    $stmt->execute([$idUtilisateur]);
    return $stmt->fetchColumn();
}

function enregistrer_vote($pdo, $idUtilisateur, $phase, $idPhoto) {
    $date = date('Y-m-d H:i:s');
    if ($phase == 1) {
        $stmt = $pdo->prepare("INSERT INTO vote1 (id_etu, id_photo, date) VALUES (:id_etu, :id_photo, :date)");
    } elseif ($phase == 2) {
        $stmt = $pdo->prepare("INSERT INTO vote2 (id_etu, id_photo, date) VALUES (:id_etu, :id_photo, :date)");
    } else {
        return false;
    }

    return $stmt->execute([
        ':id_etu' => $idUtilisateur,
        ':id_photo' => $idPhoto,
        ':date' => $date
    ]);
}

function recuperer_top10_photos($pdo) {
    $stmt = $pdo->query("
        SELECT id_photo, COUNT(*) AS nb_votes 
        FROM vote1 
        GROUP BY id_photo 
        ORDER BY nb_votes DESC 
        LIMIT 10
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function a_deja_vote_pour_photo($pdo, $idUtilisateur, $idPhoto, $phase) {
    if ($phase == 1) {
        $table = 'vote1';
    } else {
        $table = 'vote2';
    }

    $sql = "SELECT COUNT(*) FROM $table WHERE id_etu = ? AND id_photo = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idUtilisateur, $idPhoto]);

    return $stmt->fetchColumn() > 0;
}

function recuperer_ids_photos_depuis_dossier() {
    $dossier = 'photos/';
    $ids = [];
    foreach (scandir($dossier) as $fichier) {
        if (preg_match('/^(\d+)\.(jpg|jpeg|png)$/i', $fichier, $resultat)) {
            $ids[] = $resultat[1];
        }
    }
    return $ids;
}

// Anciens noms gardés pour compatibilité.
function get_phase1_start_date($pdo) { return recuperer_date_debut_vote1($pdo); }
function get_phase1_end_date($pdo) { return recuperer_date_fin_vote1($pdo); }
function get_phase2_start_date($pdo) { return recuperer_date_debut_vote2($pdo); }
function get_phase2_end_date($pdo) { return recuperer_date_fin_vote2($pdo); }
function get_vote_count($pdo, $userId, $phase) { return compter_votes($pdo, $userId, $phase); }
function insert_vote($pdo, $userId, $phase, $photoId) { return enregistrer_vote($pdo, $userId, $phase, $photoId); }
function get_top10_photos($pdo) { return recuperer_top10_photos($pdo); }
function has_already_voted_for_photo($pdo, $userId, $photoId, $phase) { return a_deja_vote_pour_photo($pdo, $userId, $photoId, $phase); }
function get_photo_ids_from_directory() { return recuperer_ids_photos_depuis_dossier(); }
