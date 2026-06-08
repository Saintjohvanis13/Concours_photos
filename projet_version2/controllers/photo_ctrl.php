<?php
require_once __DIR__ . '/../models/concours.php';
require_once __DIR__ . '/../models/photo.php';
require_once __DIR__ . '/auth_ctrl.php';

function depot_photo_ctrl() {
    obliger_connexion();
    $message = '';
    $concours = recuperer_concours_actuel();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!$concours) {
            $message = 'Aucun concours configuré.';
        } elseif (!isset($_FILES['photo']) || $_FILES['photo']['error'] != 0) {
            $message = 'Choisissez une photo.';
        } else {
            $titre = trim($_POST['titre'] ?? '');
            $lieu = trim($_POST['lieu'] ?? '');
            $datePhoto = $_POST['datePhoto'] ?? '';
            $nomOriginal = basename($_FILES['photo']['name']);
            $extension = strtolower(pathinfo($nomOriginal, PATHINFO_EXTENSION));
            $extensionsOK = array('jpg', 'jpeg', 'png', 'webp');

            if (!in_array($extension, $extensionsOK)) {
                $message = 'Format refusé. Utilisez jpg, jpeg, png ou webp.';
            } else {
                $nouveauNom = 'photo_' . $_SESSION['idUtilisateur'] . '_' . time() . '.' . $extension;
                $cheminBase = 'uploads/photos/' . $nouveauNom;
                $cheminServeur = __DIR__ . '/../' . $cheminBase;

                if (move_uploaded_file($_FILES['photo']['tmp_name'], $cheminServeur)) {
                    ajouter_photo($_SESSION['idUtilisateur'], $concours['idConcours'], $titre, $lieu, $datePhoto, $cheminBase);
                    $message = 'Photo envoyée.';
                } else {
                    $message = 'Erreur pendant l’envoi du fichier.';
                }
            }
        }
    }
    require __DIR__ . '/../views/depot_photo.php';
}

function mes_photos_ctrl() {
    obliger_connexion();
    $photos = photos_utilisateur($_SESSION['idUtilisateur']);
    require __DIR__ . '/../views/mes_photos.php';
}

function supprimer_photo_ctrl() {
    obliger_connexion();
    $idPhoto = $_GET['id'] ?? 0;
    supprimer_photo($idPhoto, $_SESSION['idUtilisateur']);
    header('Location: index.php?route=mes_photos');
    exit;
}
