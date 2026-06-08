<?php

session_start();

if (!isset($_SESSION['id'])) {
    die("Vous devez être connecté pour accéder à cette page.");
}

require_once(__DIR__ . '/../models/depot_crud.php');
require_once(__DIR__ . '/../models/Etudiant.php');

$etudiantId = $_SESSION['id'];

// Vérification de la période de dépôt
$dateDebut = getDateDebut();
$dateFin = getDateFin();
$today = date('Y-m-d');

if ($today < $dateDebut || $today > $dateFin) {
    require('views/blocs/entete.php');
    echo '<main class="page-simple">';
    echo '<h2>Phase de dépôt</h2>';
    echo '<div class="soulignement-orange"></div>';
    echo '<div class="carte-message">';
    echo '<p>Le dépôt des photos n’est pas encore ouvert.</p>';
    echo '<p><strong>Il ouvrira le ' . htmlspecialchars($dateDebut) . ' à 00h00.</strong></p>';
    echo '</div>';
    echo '<hr class="separateur">';
    echo '<p>Revenez à cette date pour déposer votre photo.</p>';
    echo '<a href="index.php?req=accueil" class="btn-retour">Retour à l’accueil</a>';
    echo '</main>';
    require('views/blocs/pied.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (photoExiste($etudiantId)) {
        $_SESSION['message'] = "Vous avez déjà déposé une photo.";
    } elseif (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['message'] = "Erreur lors de l'envoi de la photo.";
    } else {
        $description = trim($_POST['description'] ?? '');

        if (!enregistrerPhoto($etudiantId, $_FILES['photo']['tmp_name'])) {
            $_SESSION['message'] = "Erreur lors de l'enregistrement du fichier.";
        } elseif (!updateDescription($etudiantId, $description)) {
            $_SESSION['message'] = "Erreur lors de la mise à jour de la description.";
        } else {
            $_SESSION['message'] = "Photo déposée avec succès.";
        }
    }
    header('Location: index.php?req=depot');
    exit;
}

// Affichage du formulaire
include(__DIR__ . '/../views/depot_view.php');
