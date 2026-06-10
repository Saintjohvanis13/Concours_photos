<?php
if (session_status() === PHP_SESSION_NONE) {           //le contro démarre la session  et chargr les modèles
    session_start();
}

require_once(__DIR__ . '/../models/Etudiant.php');
require_once(__DIR__ . '/../models/AdminPhotos.php');

function ctrl_modifier_photos() {      //on vérifie la connexion
    if (!isset($_SESSION['id'])) {
        die("Vous devez être connecté pour accéder à cette page.");
    }

    $etudiantConnecte = recuperer_etudiant_par_id($_SESSION['id']);     // on vérifie les droits administrateur
    if (!etudiant_est_administrateur($etudiantConnecte)) {
        die("Accès réservé aux étudiants qui ont le rôle administrateur.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {    // on traite le formulaire
        $action = $_POST['action'] ?? '';
        $idPhoto = $_POST['id_photo'] ?? null;
        $nomFichier = $_POST['nom_fichier'] ?? '';

        if ($action === 'supprimer') {      //on execute les actions
            supprimer_photo_admin($idPhoto, $nomFichier);
            $_SESSION['message_admin_photos'] = "Photo supprimée.";
        } elseif ($action === 'modifier') {   // aucune erreur pendant l'upload
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK && modifier_fichier_photo_admin($idPhoto, $nomFichier, $_FILES['photo'])) {
                $_SESSION['message_admin_photos'] = "Photo modifiée.";
            } else {
                $_SESSION['message_admin_photos'] = "Erreur : le fichier envoyé doit être une image valide.";
            }
        }

        header('Location: index.php?req=modifier_photos');
        exit;
    }

    $photos = recuperer_photos_admin();
    require(__DIR__ . '/../views/admin_photos_view.php');
}
