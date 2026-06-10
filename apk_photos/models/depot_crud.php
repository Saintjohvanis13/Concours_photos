<?php
require_once(__DIR__ . '/../models/connection.php');



function photo_existe($id) {
    return file_exists(__DIR__ . '/../photos/' . $id . '.jpg');
}

function fichier_photo_valide($fichier) {
    if (!isset($fichier) || !isset($fichier['tmp_name']) || !is_uploaded_file($fichier['tmp_name'])) {
        return false;
    }

    $typesAutorises = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $type = mime_content_type($fichier['tmp_name']);

    return in_array($type, $typesAutorises, true);
}

function enregistrer_photo($id, $tmp) {
    $dossierPhotos = __DIR__ . '/../photos/';
    $dossierPublic = __DIR__ . '/../public/photos/';

    if (!is_dir($dossierPhotos)) {
        mkdir($dossierPhotos, 775, true);
    }
    if (!is_dir($dossierPublic)) {
        mkdir($dossierPublic, 775, true);
    }

    $destination = $dossierPhotos . $id . '.jpg';
    $copiePublique = $dossierPublic . $id . '.jpg';

    $resultat = move_uploaded_file($tmp, $destination);

    if ($resultat) {
        copy($destination, $copiePublique);
    }

    return $resultat;
}

function enregistrer_photo_depuis_admin($id, $fichier) {
    if (!fichier_photo_valide($fichier)) {
        return false;
    }

    return enregistrer_photo($id, $fichier['tmp_name']);
}

function supprimer_photo($id) {
    $chemins = [
        __DIR__ . '/../photos/' . $id . '.jpg',
        __DIR__ . '/../public/photos/' . $id . '.jpg'
    ];

    $supprime = false;
    foreach ($chemins as $chemin) {
        if (file_exists($chemin)) {
            unlink($chemin);
            $supprime = true;
        }
    }

    return $supprime;
}

function modifier_description($id, $description) {
    $pdo = connexion_base_de_donnees();
    $stmt = $pdo->prepare("UPDATE etudiant SET description = ? WHERE id = ?");
    return $stmt->execute([$description, $id]);
}


