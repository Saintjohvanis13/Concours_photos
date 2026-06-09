<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    die("Vous devez être connecté pour accéder à cette page.");
}

require_once(__DIR__ . '/../models/depot_crud.php');
require_once(__DIR__ . '/../models/Etudiant.php');

$etudiantId = $_SESSION['id'];
$etudiantConnecte = recuperer_etudiant_par_id($etudiantId);

if (!etudiant_est_administrateur($etudiantConnecte)) {
    $titrePage = 'Phase de dépôt';
    $messagePage = 'Revenez prochainement.';
    include(__DIR__ . '/../views/concours_non_accessible_view.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (photo_existe($etudiantId)) {
        $_SESSION['message'] = "Vous avez déjà déposé une photo.";
    } elseif (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['message'] = "Erreur lors de l'envoi de la photo.";
    } elseif (!fichier_photo_valide($_FILES['photo'])) {
        $_SESSION['message'] = "Le fichier envoyé doit être une image.";
    } else {
        $description = trim($_POST['description'] ?? '');

        if (!enregistrer_photo($etudiantId, $_FILES['photo']['tmp_name'])) {
            $_SESSION['message'] = "Erreur lors de l'enregistrement du fichier.";
        } elseif (!modifier_description($etudiantId, $description)) {
            $_SESSION['message'] = "Erreur lors de la mise à jour de la description.";
        } else {
            $_SESSION['message'] = "Photo déposée avec succès.";
        }
    }
    header('Location: index.php?req=depot');
    exit;
}

include(__DIR__ . '/../views/depot_view.php');
