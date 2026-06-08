<?php
require_once __DIR__ . '/connection.php';

function recuperer_concours_actuel() {
    $connex = connection();
    $req = $connex->prepare('SELECT * FROM Concours ORDER BY annee DESC LIMIT 1');
    $req->execute();
    return $req->fetch();
}
function modifier_infos_accueil($theme, $reglement, $prix1, $prix2, $prix3) {
    $c = recuperer_concours_actuel(); if (!$c) return;
    $connex = connection();
    $req = $connex->prepare('UPDATE Concours SET theme=:theme, reglement=:reglement, prix1=:prix1, prix2=:prix2, prix3=:prix3 WHERE idConcours=:id');
    $req->execute([':theme'=>$theme, ':reglement'=>$reglement, ':prix1'=>$prix1, ':prix2'=>$prix2, ':prix3'=>$prix3, ':id'=>$c['idConcours']]);
}
function modifier_dates($debutDepot,$finDepot,$debutVote,$finVote,$resultats) {
    $c = recuperer_concours_actuel(); if (!$c) return;
    $connex = connection();
    $req = $connex->prepare('UPDATE Concours SET dateDebutDepot=:a,dateFinDepot=:b,dateDebutVote=:c,dateFinVote=:d,dateResultats=:e WHERE idConcours=:id');
    $req->execute([':a'=>$debutDepot, ':b'=>$finDepot, ':c'=>$debutVote, ':d'=>$finVote, ':e'=>$resultats, ':id'=>$c['idConcours']]);
}
