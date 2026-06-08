<?php
require_once("models/connection.php");

// Récupérer tous les IDs d'étudiants
function get_all_etudiants() {
    $pdo = connection();
    $stmt = $pdo->query("SELECT id FROM etudiant");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupérer un étudiant par son ID (login, admin, etc.)
function getEtudiantById($id) {
    $pdo = connection();
    $stmt = $pdo->prepare("SELECT * FROM etudiant WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
