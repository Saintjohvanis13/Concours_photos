<?php
require_once(__DIR__ . '/../models/connection.php');

function recuperer_date_debut_depot() {
    $pdo = connexion_base_de_donnees();
    $sql = "SELECT valeur FROM configuration WHERE parametre = 'depot_debut'";
    return $pdo->query($sql)->fetchColumn();
}

function recuperer_date_fin_depot() {
    $pdo = connexion_base_de_donnees();
    $sql = "SELECT valeur FROM configuration WHERE parametre = 'depot_fin'";
    return $pdo->query($sql)->fetchColumn();
}

function photo_existe($id) {
    return file_exists(__DIR__ . '/../photos/' . $id . '.jpg');
}

function enregistrer_photo($id, $tmp) {
    $destination = __DIR__ . '/../photos/' . $id . '.jpg';
    return move_uploaded_file($tmp, $destination);
}

function modifier_description($id, $description) {
    $pdo = connexion_base_de_donnees();
    $stmt = $pdo->prepare("UPDATE etudiant SET description = ? WHERE id = ?");
    return $stmt->execute([$description, $id]);
}

// Anciens noms gardés pour compatibilité.
function getDateDebut() { return recuperer_date_debut_depot(); }
function getDateFin() { return recuperer_date_fin_depot(); }
function photoExiste($id) { return photo_existe($id); }
function enregistrerPhoto($id, $tmp) { return enregistrer_photo($id, $tmp); }
function updateDescription($id, $description) { return modifier_description($id, $description); }
