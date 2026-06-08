<?php
require_once __DIR__ . '/connection.php';
function a_deja_vote($idUtilisateur) {
    $connex = connection();
    $req = $connex->prepare('SELECT COUNT(*) nb FROM Vote WHERE idUtilisateur=:id AND tour=1');
    $req->execute([':id'=>$idUtilisateur]); $r=$req->fetch(); return $r['nb'] > 0;
}
function enregistrer_votes($idUtilisateur, $idsPhotos) {
    $connex = connection();
    $req = $connex->prepare('INSERT INTO Vote(idUtilisateur,idPhoto,dateVote,tour) VALUES(:u,:p,NOW(),1)');
    foreach ($idsPhotos as $idPhoto) $req->execute([':u'=>$idUtilisateur, ':p'=>$idPhoto]);
}
function votes_utilisateur($idUtilisateur) {
    $connex = connection();
    $req = $connex->prepare('SELECT p.* FROM Vote v JOIN Photo p ON v.idPhoto=p.idPhoto WHERE v.idUtilisateur=:id ORDER BY v.dateVote DESC');
    $req->execute([':id'=>$idUtilisateur]); return $req->fetchAll();
}
function resultats_votes() {
    $connex = connection();
    $req = $connex->prepare('SELECT p.*, COUNT(v.idVote) nbVotes FROM Photo p LEFT JOIN Vote v ON p.idPhoto=v.idPhoto GROUP BY p.idPhoto ORDER BY nbVotes DESC');
    $req->execute(); return $req->fetchAll();
}
