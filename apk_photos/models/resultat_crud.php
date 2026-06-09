<?php
require_once(__DIR__ . '/connection.php');

function resultats_sont_actifs() {
    $db = connexion_base_de_donnees();

    $stmt = $db->prepare("
        SELECT parametre, valeur 
        FROM configuration 
        WHERE parametre IN ('resultat2_debut', 'resultat2_fin')
    ");
    $stmt->execute();
    $dates = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    $today = date('Y-m-d');
    return ($today >= $dates['resultat2_debut'] && $today <= $dates['resultat2_fin']);
}

function recuperer_top3_photos_tour2() {
    $db = connexion_base_de_donnees();

    $query = "
        SELECT id_photo, COUNT(*) AS nb_votes
        FROM vote2
        GROUP BY id_photo
        ORDER BY nb_votes DESC
        LIMIT 3
    ";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($resultats as &$ligne) {
        $id = $ligne['id_photo'];
        $ligne['image'] = "photos/" . $id . ".jpg";
        $ligne['description'] = "Photo n°" . $id;
    }

    return $resultats;
}

