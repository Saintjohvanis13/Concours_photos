<?php
require_once __DIR__ . '/../config/ldap.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/connection.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    include __DIR__ . '/../views/login.php';
    exit;
}

$login = trim($_POST['login'] ?? '');
$pass = $_POST['pass'] ?? '';

$user = User::authenticate($login, $pass);

if (!$user['success']) {
    $error = $user['message'] ?? 'Identifiants incorrects.';
    include __DIR__ . '/../views/login.php';
    exit;
}

try {
    $pdo = connection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $prenom = trim($user['prenom'] ?? '');
    $nom = trim($user['nom'] ?? '');
    $loginComplet = trim($prenom . ' ' . $nom);
    $dateConnexion = date('Y-m-d H:i:s');

    // On regarde si l'étudiant existe déjà.
    $stmt = $pdo->prepare('SELECT id, admin FROM etudiant WHERE login = ?');
    $stmt->execute([$loginComplet]);
    $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$etudiant) {
        // description est obligatoire dans la base, donc on met une valeur vide.
        $stmt = $pdo->prepare("INSERT INTO etudiant (login, admin, date, description) VALUES (?, 0, ?, '')");
        $stmt->execute([$loginComplet, $dateConnexion]);

        $etudiantId = $pdo->lastInsertId();
        $isAdmin = false;
    } else {
        $etudiantId = $etudiant['id'];
        $isAdmin = (bool)$etudiant['admin'];
    }

    $_SESSION['id'] = $etudiantId;
    $_SESSION['role'] = $isAdmin ? 'admin' : 'etudiant';

    header('Location: index.php?req=accueil');
    exit;

} catch (PDOException $e) {
    $error = 'Erreur de base de données : ' . $e->getMessage();
    include __DIR__ . '/../views/login.php';
    exit;
}
