<?php
// On démarre la session si elle n'est pas déjà lancée.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// On vérifie que l'utilisateur est connecté.
if (!isset($_SESSION['id'])) {
    die("Vous devez être connecté pour accéder à cette page.");
}

require_once(__DIR__ . '/../models/depot_crud.php');
require_once(__DIR__ . '/../models/Etudiant.php');

// On récupère l'étudiant connecté.
$etudiantId = $_SESSION['id'];
$etudiantConnecte = recuperer_etudiant_par_id($etudiantId);

// Seuls les administrateurs peuvent déposer une photo.
if (!etudiant_est_administrateur($etudiantConnecte)) {
    $titrePage = 'Phase de dépôt';
    $messagePage = 'Revenez prochainement.';
    include(__DIR__ . '/../views/concours_non_accessible_view.php');
    exit;
}

// Si le formulaire est envoyé, on traite la photo.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $photoEnvoyee = $_FILES['photo'] ?? null;
    $description = trim($_POST['description'] ?? '');

    if (photo_existe($etudiantId)) {
        $_SESSION['message'] = "Vous avez déjà déposé une photo.";
    } elseif (!$photoEnvoyee || $photoEnvoyee['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['message'] = "Erreur lors de l'envoi de la photo.";
    } elseif (!fichier_photo_valide($photoEnvoyee)) {
        $_SESSION['message'] = "Le fichier envoyé doit être une image.";
    } elseif (!enregistrer_photo($etudiantId, $photoEnvoyee['tmp_name'])) {
        $_SESSION['message'] = "Erreur lors de l'enregistrement du fichier.";
    } elseif (!modifier_description($etudiantId, $description)) {
        $_SESSION['message'] = "Erreur lors de la mise à jour de la description.";
    } else {
        $_SESSION['message'] = "Photo déposée avec succès.";
    }

    // On recharge la page pour éviter un nouveau dépôt si l'utilisateur actualise.
    header('Location: index.php?req=depot');
    exit;
}

// Si le formulaire n'est pas envoyé, on affiche simplement la page.
include(__DIR__ . '/../views/depot_view.php');
