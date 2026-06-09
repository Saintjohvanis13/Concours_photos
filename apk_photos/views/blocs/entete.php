<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitre = 'Concours Photo';
$reqCourante = $_GET['req'] ?? 'accueil';
if ($reqCourante === 'depot') {
    $pageTitre = 'Dépôt des photos';
} elseif ($reqCourante === 'vote') {
    $pageTitre = 'Vote';
} elseif ($reqCourante === 'resultat') {
    $pageTitre = 'Résultats';
} elseif ($reqCourante === 'admin') {
    $pageTitre = 'Administration';
} elseif ($reqCourante === 'modifier_photos') {
    $pageTitre = 'Modifier les photos';
} elseif ($reqCourante === 'utilisateurs_admin') {
    $pageTitre = 'Utilisateurs';
}

echo '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAE_203 - Concours Photo</title>
    <link rel="stylesheet" type="text/css" href="public/css/style_entete.css">
    <link rel="stylesheet" type="text/css" href="public/css/style_menu.css">
    <link rel="stylesheet" href="public/css/style_log_acc.css">
    <link rel="stylesheet" href="public/css/style_depot.css">
    <link rel="stylesheet" href="public/css/vote.css">
    <link rel="stylesheet" href="public/css/admin.css">
    <script src="public/js/script.js" defer></script>
</head>
<body>
    <header class="entete">
        <a class="marque" href="index.php?req=accueil">
            <span class="logo-cadre"><img src="public/images/logo-iut.png" alt="Logo IUT de Châtellerault" class="logo"></span>
        </a>
        <div class="titre-entete">' . htmlspecialchars($pageTitre) . '</div>';

require("views/blocs/menu.php");

echo '</header>';
