<?php
require_once('models/resultat_crud.php');

function afficherTop3Resultats() {
    $photosTop3 = getTop3PhotosTour2(); // peut retourner null si date invalide
    require('views/resultats_view.php');
}

