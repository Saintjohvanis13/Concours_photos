<?php
require_once __DIR__ . '/../models/concours.php';
require_once __DIR__ . '/auth_ctrl.php';

function accueil_ctrl() {
    $concours = recuperer_concours_actuel();
    require __DIR__ . '/../views/accueil.php';
}

function espace_ctrl() {
    obliger_connexion();
    require __DIR__ . '/../views/espace.php';
}
