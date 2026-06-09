<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../models/Etudiant.php');

function ctrl_utilisateurs_admin() {
    if (!isset($_SESSION['id'])) {
        die("Vous devez être connecté pour accéder à cette page.");
    }

    $etudiantConnecte = recuperer_etudiant_par_id($_SESSION['id']);
    if (!etudiant_est_administrateur($etudiantConnecte)) {
        die("Accès réservé aux étudiants qui ont le rôle administrateur.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        $idEtudiant = (int)($_POST['id_etudiant'] ?? 0);

        if ($idEtudiant > 0 && $idEtudiant !== (int)$_SESSION['id']) {
            if ($action === 'bloquer') {
                modifier_description_etudiant($idEtudiant, 'bloque');
                $_SESSION['message_admin_utilisateurs'] = "Utilisateur bloqué.";
            } elseif ($action === 'debloquer') {
                modifier_description_etudiant($idEtudiant, '');
                $_SESSION['message_admin_utilisateurs'] = "Utilisateur débloqué.";
            }
        } else {
            $_SESSION['message_admin_utilisateurs'] = "Action impossible sur ce compte.";
        }

        header('Location: index.php?req=utilisateurs_admin');
        exit;
    }

    $etudiants = recuperer_tous_etudiants();
    require(__DIR__ . '/../views/admin_utilisateurs_view.php');
}
