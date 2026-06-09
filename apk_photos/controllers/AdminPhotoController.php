<?php
require_once("models/Etudiant.php");

function ctrl_photos_admin() {
    session_start();
 
  
    $photo_dir = "public/photos/";

    // Suppression si demandée

    $msg = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_etudiant'])) {
        $photo_id = basename($_POST['id_etudiant']);
        $photo_path = __DIR__ . "/../photos/" . $photo_id . ".jpg";
        if (file_exists($photo_path)) {
            unlink($photo_path);
            $msg = "Photo supprimée avec succès.";
        } else {
            $msg = "Photo introuvable.";
        }
    }

    $etudiants = recuperer_tous_etudiants();
    include("views/admin_photos_view.php");
}


