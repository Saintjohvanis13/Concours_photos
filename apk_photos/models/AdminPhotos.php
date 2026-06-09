<?php
require_once(__DIR__ . '/connection.php');

function chemin_photo_securise($nomFichier) {
    $nom = basename((string)$nomFichier);
    if ($nom === '' || $nom === '.' || $nom === '..') {
        return null;
    }
    return 'photos/' . $nom;
}

function recuperer_photo_admin_par_id($idPhoto) {
    $pdo = connexion_base_de_donnees();
    $stmt = $pdo->prepare("SELECT * FROM photo WHERE id = ?");
    $stmt->execute([(int)$idPhoto]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function recuperer_photos_admin() {
    $pdo = connexion_base_de_donnees();
    $photos = [];
    $nomsDejaAffiches = [];

    $sql = "SELECT p.id, p.nom_fichier, p.date_depot, p.id_etu, e.login
            FROM photo p
            LEFT JOIN etudiant e ON e.id = p.id_etu
            ORDER BY p.date_depot DESC, p.id DESC";
    $stmt = $pdo->query($sql);
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $ligne) {
        $chemin = chemin_photo_securise($ligne['nom_fichier']);
        if ($chemin === null) {
            continue;
        }
        $nom = basename($chemin);
        $nomsDejaAffiches[$nom] = true;
        $ligne['chemin_affichage'] = $chemin;
        $ligne['nom_affiche'] = $nom;
        $ligne['source'] = 'base';
        $photos[] = $ligne;
    }

    $dossier = __DIR__ . '/../photos/';
    if (is_dir($dossier)) {
        foreach (scandir($dossier) as $fichier) {
            if (!preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $fichier)) {
                continue;
            }
            if (isset($nomsDejaAffiches[$fichier])) {
                continue;
            }
            $photos[] = [
                'id' => null,
                'nom_fichier' => 'photos/' . $fichier,
                'chemin_affichage' => 'photos/' . $fichier,
                'nom_affiche' => $fichier,
                'date_depot' => date('Y-m-d H:i:s', filemtime($dossier . $fichier)),
                'id_etu' => null,
                'login' => '',
                'source' => 'dossier'
            ];
        }
    }

    return $photos;
}

function fichier_image_valide_admin($fichier) {
    if (!isset($fichier) || !isset($fichier['tmp_name']) || !is_uploaded_file($fichier['tmp_name'])) {
        return false;
    }
    $typesAutorises = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $type = mime_content_type($fichier['tmp_name']);
    return in_array($type, $typesAutorises, true);
}

function extension_photo_admin($fichier) {
    $type = mime_content_type($fichier['tmp_name']);
    if ($type === 'image/png') return 'png';
    if ($type === 'image/gif') return 'gif';
    if ($type === 'image/webp') return 'webp';
    return 'jpg';
}

function modifier_fichier_photo_admin($idPhoto, $nomFichierActuel, $fichier) {
    if (!fichier_image_valide_admin($fichier)) {
        return false;
    }

    $cheminRelatif = null;
    if (!empty($idPhoto)) {
        $photo = recuperer_photo_admin_par_id($idPhoto);
        if ($photo) {
            $cheminRelatif = chemin_photo_securise($photo['nom_fichier']);
        }
    }
    if ($cheminRelatif === null) {
        $cheminRelatif = chemin_photo_securise($nomFichierActuel);
    }
    if ($cheminRelatif === null) {
        return false;
    }

    $dossierPhotos = __DIR__ . '/../photos/';
    $dossierPublic = __DIR__ . '/../public/photos/';
    if (!is_dir($dossierPhotos)) mkdir($dossierPhotos, 0775, true);
    if (!is_dir($dossierPublic)) mkdir($dossierPublic, 0775, true);

    $destination = chemin_photo_absolu($cheminRelatif);
    $copiePublique = chemin_photo_public_absolu($cheminRelatif);

    if (!$destination || !move_uploaded_file($fichier['tmp_name'], $destination)) {
        return false;
    }
    copy($destination, $copiePublique);
    return true;
}

function supprimer_photo_admin($idPhoto, $nomFichier) {
    $pdo = connexion_base_de_donnees();
    $cheminRelatif = chemin_photo_securise($nomFichier);

    if (!empty($idPhoto)) {
        $photo = recuperer_photo_admin_par_id($idPhoto);
        if ($photo) {
            $cheminRelatif = chemin_photo_securise($photo['nom_fichier']);
            $pdo->prepare("DELETE FROM photo WHERE id = ?")->execute([(int)$idPhoto]);
        }
    }

    if ($cheminRelatif !== null) {
        $nomSansExtension = pathinfo($cheminRelatif, PATHINFO_FILENAME);
        if (ctype_digit($nomSansExtension)) {
            $pdo->prepare("DELETE FROM vote1 WHERE id_photo = ?")->execute([(int)$nomSansExtension]);
            $pdo->prepare("DELETE FROM vote2 WHERE id_photo = ?")->execute([(int)$nomSansExtension]);
        }

        $chemins = [
            chemin_photo_absolu($cheminRelatif),
            chemin_photo_public_absolu($cheminRelatif)
        ];
        foreach ($chemins as $chemin) {
            if ($chemin && file_exists($chemin)) {
                unlink($chemin);
            }
        }
    }

    return true;
}
