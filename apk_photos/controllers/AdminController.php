<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'models/Etudiant.php';

function ctrl_admin() {
    if (!isset($_SESSION['id'])) {
        die("Vous devez être connecté pour accéder à l'administration.");
    }

    $etudiant = recuperer_etudiant_par_id($_SESSION['id']);

    if (!etudiant_est_administrateur($etudiant)) {
        die("Accès réservé aux étudiants qui ont le rôle administrateur.");
    }

    require 'views/admin_view.php';
}
