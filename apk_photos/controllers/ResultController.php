<?php
require_once('models/resultat_crud.php');

function afficher_top3_resultats() {
    $photosTop3 = recuperer_top3_photos_tour2(); // peut retourner null si date invalide
    require('views/resultats_view.php');
}

