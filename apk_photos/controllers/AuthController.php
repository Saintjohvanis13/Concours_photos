<?php
require_once __DIR__ . '/../config/ldap.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/connection.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function recuperer_colonnes_etudiant(PDO $pdo) {
    $colonnes = [];
    $stmt = $pdo->query('SHOW COLUMNS FROM etudiant');
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $colonne) {
        $colonnes[] = $colonne['Field'];
    }
    return $colonnes;
}

function determiner_role_etudiant(array $etudiant) {
    if (isset($etudiant['admin']) && (int)$etudiant['admin'] === 1) {
        return 'admin';
    }

    if (isset($etudiant['role']) && strtolower(trim($etudiant['role'])) === 'admin') {
        return 'admin';
    }

    return 'etudiant';
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    include __DIR__ . '/../views/login.php';
    exit;
}

$login = trim($_POST['login'] ?? '');
$pass = $_POST['pass'] ?? '';

$utilisateur = User::authentifier($login, $pass);

if (!$utilisateur['success']) {
    $error = $utilisateur['message'] ?? 'Identifiants incorrects.';
    include __DIR__ . '/../views/login.php';
    exit;
}

try {
    $pdo = connexion_base_de_donnees();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $prenom = trim($utilisateur['prenom'] ?? '');
    $nom = trim($utilisateur['nom'] ?? '');
    $loginComplet = trim($prenom . ' ' . $nom);
    $dateConnexion = date('Y-m-d H:i:s');

    $colonnes = recuperer_colonnes_etudiant($pdo);
    $aColonneAdmin = in_array('admin', $colonnes, true);
    $aColonneRole = in_array('role', $colonnes, true);

    $champs = ['id'];
    if ($aColonneAdmin) {
        $champs[] = 'admin';
    }
    if ($aColonneRole) {
        $champs[] = 'role';
    }

    // On regarde si l'étudiant existe déjà.
    $sql = 'SELECT ' . implode(', ', $champs) . ' FROM etudiant WHERE login = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$loginComplet]);
    $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$etudiant) {
        // On ne modifie pas la structure de la base : on remplit seulement les colonnes qui existent.
        $colonnesInsertion = ['login', 'date', 'description'];
        $valeursInsertion = [$loginComplet, $dateConnexion, ''];

        if ($aColonneAdmin) {
            $colonnesInsertion[] = 'admin';
            $valeursInsertion[] = 0;
        }
        if ($aColonneRole) {
            $colonnesInsertion[] = 'role';
            $valeursInsertion[] = 'etudiant';
        }

        $placeholders = implode(', ', array_fill(0, count($colonnesInsertion), '?'));
        $sqlInsertion = 'INSERT INTO etudiant (' . implode(', ', $colonnesInsertion) . ') VALUES (' . $placeholders . ')';
        $stmt = $pdo->prepare($sqlInsertion);
        $stmt->execute($valeursInsertion);

        $etudiantId = $pdo->lastInsertId();
        $role = 'etudiant';
    } else {
        $etudiantId = $etudiant['id'];
        $role = determiner_role_etudiant($etudiant);
    }

    $_SESSION['id'] = $etudiantId;
    $_SESSION['role'] = $role;

    header('Location: index.php?req=accueil');
    exit;

} catch (PDOException $e) {
    $error = 'Erreur de base de données : ' . $e->getMessage();
    include __DIR__ . '/../views/login.php';
    exit;
}
