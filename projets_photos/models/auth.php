<?php
require_once __DIR__ . '/connection.php';
require_once __DIR__ . '/../config/ldap.php';

/**
 * Cherche l'utilisateur dans la base.
 * S'il n'existe pas encore, on le crée automatiquement.
 */
function creer_ou_recuperer_utilisateur($infosLdap) {
    $connex = connection();

    $req = $connex->prepare('SELECT * FROM Utilisateur WHERE login = :login LIMIT 1');
    $req->bindValue(':login', $infosLdap['uid']);
    $req->execute();
    $utilisateur = $req->fetch();

    if ($utilisateur) {
        return $utilisateur;
    }

    $ajout = $connex->prepare(
        'INSERT INTO Utilisateur(nom, prenom, email, login, role, bloque)
         VALUES(:nom, :prenom, :email, :login, :role, 0)'
    );

    $ajout->bindValue(':nom', $infosLdap['nom']);
    $ajout->bindValue(':prenom', $infosLdap['prenom']);
    $ajout->bindValue(':email', $infosLdap['email'] ?? '');
    $ajout->bindValue(':login', $infosLdap['uid']);
    $ajout->bindValue(':role', 'utilisateur');
    $ajout->execute();

    $id = $connex->lastInsertId();

    $req = $connex->prepare('SELECT * FROM Utilisateur WHERE idUtilisateur = :id LIMIT 1');
    $req->bindValue(':id', $id, PDO::PARAM_INT);
    $req->execute();

    return $req->fetch();
}

/**
 * Connecte l'utilisateur avec le LDAP puis crée la session PHP.
 * Session = mémoire temporaire côté serveur pour garder l'utilisateur connecté.
 */
function connecter_utilisateur($login, $motDePasse) {
    $infosLdap = ldap_authenticate($login, $motDePasse);

    if (!$infosLdap) {
        return false;
    }

    $utilisateur = creer_ou_recuperer_utilisateur($infosLdap);

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

function deconnecter_utilisateur() {
    $_SESSION = [];
    session_destroy();
}
