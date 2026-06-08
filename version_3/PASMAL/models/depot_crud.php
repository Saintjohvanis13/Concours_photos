<?php
require_once(__DIR__ . '/../models/connection.php');

function getDateDebut() {
    $pdo = connection();
    $sql = "SELECT valeur FROM configuration WHERE parametre = 'depot_debut'";
    return $pdo->query($sql)->fetchColumn();
}

function getDateFin() {
    $pdo = connection();
    $sql = "SELECT valeur FROM configuration WHERE parametre = 'depot_fin'";
    return $pdo->query($sql)->fetchColumn();
}

function photoExiste($id) {
    return file_exists(__DIR__ . '/../photos/' . $id . '.jpg');
}

function enregistrerPhoto($id, $tmp) {
    $destination = __DIR__ . '/../photos/' . $id . '.jpg';
    return move_uploaded_file($tmp, $destination);
}

function updateDescription($id, $description) {
    $pdo = connection();
    $stmt = $pdo->prepare("UPDATE etudiant SET description = ? WHERE id = ?");
    return $stmt->execute([$description, $id]);
}
