<?php
require_once("models/connection.php");

// Récupérer tous les étudiants avec leurs informations utiles.
function recuperer_tous_etudiants() {
    $pdo = connexion_base_de_donnees();
    $stmt = $pdo->query("SELECT * FROM etudiant ORDER BY id ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupérer un étudiant par son ID (login, admin, rôle, description, etc.).
function recuperer_etudiant_par_id($id) {
    $pdo = connexion_base_de_donnees();
    $stmt = $pdo->prepare("SELECT * FROM etudiant WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Vérifier si un étudiant est administrateur.
function etudiant_est_administrateur($etudiant) {
    if (!$etudiant) {
        return false;
    }

    if (isset($etudiant['admin']) && (int)$etudiant['admin'] === 1) {
        return true;
    }

    if (isset($etudiant['role']) && strtolower(trim($etudiant['role'])) === 'admin') {
        return true;
    }

    return false;
}



function modifier_description_etudiant($id, $description) {
    $pdo = connexion_base_de_donnees();
    $stmt = $pdo->prepare("UPDATE etudiant SET description = ? WHERE id = ?");
    return $stmt->execute([$description, (int)$id]);
}

function etudiant_est_bloque($etudiant) {
    if (!$etudiant || !isset($etudiant['description'])) {
        return false;
    }
    return strtolower(trim($etudiant['description'])) === 'bloque';
}



