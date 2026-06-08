<?php
require_once __DIR__ . '/connection.php';

function ajouter_photo($idUtilisateur, $idConcours, $titre, $lieu, $datePhoto, $chemin) {
    $connex = connection();
    $req = $connex->prepare('INSERT INTO Photo(idUtilisateur,idConcours,titre,lieu,datePhoto,cheminFichier,statut,dateDepot) VALUES(:u,:c,:t,:l,:d,:ch,"en_attente",NOW())');
    $req->execute([':u'=>$idUtilisateur, ':c'=>$idConcours, ':t'=>$titre, ':l'=>$lieu, ':d'=>$datePhoto, ':ch'=>$chemin]);
}
function photos_utilisateur($idUtilisateur) {
    $connex = connection();
    $req = $connex->prepare('SELECT * FROM Photo WHERE idUtilisateur=:id ORDER BY dateDepot DESC');
    $req->execute([':id'=>$idUtilisateur]); return $req->fetchAll();
}
function toutes_photos_acceptees() {
    $connex = connection();
    $req = $connex->prepare('SELECT * FROM Photo WHERE statut="acceptee" OR statut="acceptée" OR statut="en_attente" ORDER BY idPhoto DESC');
    $req->execute(); return $req->fetchAll();
}
function toutes_photos() {
    $connex = connection();
    $req = $connex->prepare('SELECT p.*, u.nom, u.prenom FROM Photo p JOIN Utilisateur u ON p.idUtilisateur=u.idUtilisateur ORDER BY p.dateDepot DESC');
    $req->execute(); return $req->fetchAll();
}
function supprimer_photo($idPhoto, $idUtilisateur) {
    $connex = connection();
    $req = $connex->prepare('DELETE FROM Photo WHERE idPhoto=:p AND idUtilisateur=:u');
    $req->execute([':p'=>$idPhoto, ':u'=>$idUtilisateur]);
}
function changer_statut_photo($idPhoto, $statut) {
    $connex = connection();
    $req = $connex->prepare('UPDATE Photo SET statut=:s WHERE idPhoto=:p');
    $req->execute([':s'=>$statut, ':p'=>$idPhoto]);
}
