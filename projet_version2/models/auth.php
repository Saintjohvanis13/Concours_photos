<?php
require_once __DIR__ . '/connection.php';
require_once __DIR__ . '/../config/ldap.php';

function creer_ou_recuperer_utilisateur($infosLdap) {
    $connex = connection();

    $req = $connex->prepare('SELECT * FROM Utilisateur WHERE login = :login LIMIT 1');
    $req->bindValue(':login', $infosLdap['uid']);
    $req->execute();
    $utilisateur = $req->fetch();

    if ($utilisateur) {
        return $utilisateur;
    }

    $ajout = $connex->prepare('INSERT INTO Utilisateur(nom, prenom, email, login, role, bloque)
                               VALUES(:nom, :prenom, :email, :login, :role, 0)');
    $ajout->bindValue(':nom', $infosLdap['nom']);
    $ajout->bindValue(':prenom', $infosLdap['prenom']);
    $ajout->bindValue(':email', $infosLdap['email'] ?? '');
    $ajout->bindValue(':login', $infosLdap['uid']);
    $ajout->bindValue(':role', 'etudiant');
    $ajout->execute();

    $idUtilisateur = $connex->lastInsertId();

    $req = $connex->prepare('SELECT * FROM Utilisateur WHERE idUtilisateur = :idUtilisateur LIMIT 1');
    $req->bindValue(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
    $req->execute();

    return $req->fetch();
}

function connecter_utilisateur($login, $motDePasse) {
    $infosLdap = ldap_authenticate($login, $motDePasse);

    if (!$infosLdap) {
        return false;
    }

    $utilisateur = creer_ou_recuperer_utilisateur($infosLdap);

    if (!$utilisateur) {
        return false;
    }

    if (!empty($utilisateur['bloque'])) {
        return 'bloque';
    }

    $_SESSION['idUtilisateur'] = $utilisateur['idUtilisateur'];
    $_SESSION['login'] = $utilisateur['login'];
    $_SESSION['nom'] = $utilisateur['nom'];
    $_SESSION['prenom'] = $utilisateur['prenom'];
    $_SESSION['role'] = $utilisateur['role'];

    return true;
}

function est_connecte() {
    return isset($_SESSION['idUtilisateur']);
}

function est_admin() {
    return est_connecte() && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'administrateur');
}

function deconnecter_utilisateur() {
    $_SESSION = array();
    session_destroy();
}
