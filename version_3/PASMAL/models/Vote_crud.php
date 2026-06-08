<?php
function get_phase1_start_date($pdo) {
    $stmt = $pdo->prepare("SELECT valeur FROM configuration WHERE parametre = 'vote1_debut'");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function get_phase1_end_date($pdo) {
    $stmt = $pdo->prepare("SELECT valeur FROM configuration WHERE parametre = 'vote1_fin'");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function get_phase2_start_date($pdo) {
    $stmt = $pdo->prepare("SELECT valeur FROM configuration WHERE parametre = 'vote2_debut'");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function get_phase2_end_date($pdo) {
    $stmt = $pdo->prepare("SELECT valeur FROM configuration WHERE parametre = 'vote2_fin'");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function get_vote_count($pdo, $userId, $phase) {
    $table = ($phase == 1) ? "vote1" : "vote2";
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM $table WHERE id_etu = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchColumn();
}

function insert_vote($pdo, $userId, $phase, $photoId) {
    $date = date('Y-m-d H:i:s');
    if ($phase == 1) {
        $stmt = $pdo->prepare("INSERT INTO vote1 (id_etu, id_photo, date) VALUES (:id_etu, :id_photo, :date)");
    } elseif ($phase == 2) {
        $stmt = $pdo->prepare("INSERT INTO vote2 (id_etu, id_photo, date) VALUES (:id_etu, :id_photo, :date)");
    } else {
        return false;
    }

    return $stmt->execute([
        ':id_etu' => $userId,
        ':id_photo' => $photoId,
        ':date' => $date
    ]);
}

function get_top10_photos($pdo) {
    $stmt = $pdo->query("
        SELECT id_photo, COUNT(*) AS nb_votes 
        FROM vote1 
        GROUP BY id_photo 
        ORDER BY nb_votes DESC 
        LIMIT 10
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function has_already_voted_for_photo($pdo, $userId, $photoId, $phase) {
    if ($phase == 1) {
        $table = 'vote1';
    } else {
        $table = 'vote2';
    }

    $sql = "SELECT COUNT(*) FROM $table WHERE id_etu = ? AND id_photo = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId, $photoId]);

    return $stmt->fetchColumn() > 0;
}

function get_photo_ids_from_directory() {
    $dir = 'photos/';
    $ids = [];
    foreach (scandir($dir) as $file) {
        if (preg_match('/^(\d+)\.(jpg|jpeg|png)$/i', $file, $match)) {
            $ids[] = $match[1];
        }
    }
    return $ids;
}
