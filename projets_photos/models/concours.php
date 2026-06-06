<?php

require_once __DIR__ . '/connection.php';

function recuperer_concours_actuel() {
    $connex = connection();

    $req = $connex->prepare('SELECT * FROM Concours ORDER BY annee DESC LIMIT 1');
    $req->execute();

    return $req->fetch();
}