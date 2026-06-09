<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("models/Admin.php");
require_once("models/Etudiant.php");

function ctrl_admin() {
    if (!isset($_SESSION['id'])) {
        die("Vous devez être connecté pour accéder à l'administration.");
    }

    $etudiantConnecte = recuperer_etudiant_par_id($_SESSION['id']);
    if (!etudiant_est_administrateur($etudiantConnecte)) {
        die("Accès réservé aux étudiants qui ont le rôle administrateur.");
    }

    $msg = null;
    $etudiants = recuperer_tous_etudiants();
    $config = recuperer_toute_configuration();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach ($config as $param => $valeur_actuelle) {
            if (!empty($_POST[$param]) && $_POST[$param] != $valeur_actuelle) {
                modifier_configuration($param, $_POST[$param]);
                $config[$param] = $_POST[$param];
            }
        }
        $msg = "Dates mises à jour avec succès.";
    }

    include("views/admin_view.php");
}
