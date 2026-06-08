<?php
require_once __DIR__ . '/connection.php';
function tous_utilisateurs() {
    $connex = connection();
    $req = $connex->prepare('SELECT * FROM Utilisateur ORDER BY nom, prenom');
    $req->execute(); return $req->fetchAll();
}
function changer_blocage($id, $bloque) {
    $connex = connection();
    $req = $connex->prepare('UPDATE Utilisateur SET bloque=:b WHERE idUtilisateur=:id');
    $req->execute([':b'=>$bloque, ':id'=>$id]);
}
