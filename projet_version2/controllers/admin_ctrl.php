<?php
require_once __DIR__ . '/../models/concours.php';
require_once __DIR__ . '/../models/photo.php';
require_once __DIR__ . '/../models/utilisateur.php';
require_once __DIR__ . '/../models/vote.php';
require_once __DIR__ . '/auth_ctrl.php';

function admin_ctrl() {
    obliger_admin();
    require __DIR__ . '/../views/admin.php';
}

function admin_accueil_ctrl() {
    obliger_admin();
    $concours = recuperer_concours_actuel();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        modifier_infos_accueil($_POST['theme'], $_POST['reglement'], $_POST['prix1'], $_POST['prix2'], $_POST['prix3']);
        header('Location: index.php?route=admin');
        exit;
    }
    require __DIR__ . '/../views/admin_accueil.php';
}

function admin_dates_ctrl() {
    obliger_admin();
    $concours = recuperer_concours_actuel();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        modifier_dates($_POST['dateDebutDepot'], $_POST['dateFinDepot'], $_POST['dateDebutVote'], $_POST['dateFinVote'], $_POST['dateResultats']);
        header('Location: index.php?route=admin');
        exit;
    }
    require __DIR__ . '/../views/admin_dates.php';
}

function admin_photos_ctrl() {
    obliger_admin();
    if (isset($_GET['id']) && isset($_GET['statut'])) {
        changer_statut_photo($_GET['id'], $_GET['statut']);
    }
    $photos = toutes_photos();
    require __DIR__ . '/../views/admin_photos.php';
}

function admin_bloquer_ctrl() {
    obliger_admin();
    if (isset($_GET['id']) && isset($_GET['bloque'])) {
        changer_blocage($_GET['id'], $_GET['bloque']);
    }
    $utilisateurs = tous_utilisateurs();
    require __DIR__ . '/../views/admin_bloquer.php';
}

function resultats_ctrl() {
    obliger_admin();
    $resultats = resultats_votes();
    require __DIR__ . '/../views/resultats.php';
}
