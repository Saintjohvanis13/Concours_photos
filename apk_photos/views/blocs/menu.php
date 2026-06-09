<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'models/Etudiant.php';

$login = '';
$estAdmin = false;
if (isset($_SESSION['id'])) {
    $etudiant = recuperer_etudiant_par_id($_SESSION['id']);
    if ($etudiant) {
        $login = $etudiant['login'];
        $estAdmin = etudiant_est_administrateur($etudiant);
    }
}
$req = $_GET['req'] ?? 'accueil';
function classe_active($nom, $req) {
    return $nom === $req ? ' class="active"' : '';
}
?>

<nav class="menu">
    <ul>
        <li><a<?= classe_active('accueil', $req) ?> href="index.php?req=accueil">Accueil</a></li>
        <li><a<?= classe_active('depot', $req) ?> href="index.php?req=depot">Dépôts</a></li>
        <li><a<?= classe_active('vote', $req) ?> href="index.php?req=vote">Votes</a></li>
        <li><a<?= classe_active('resultat', $req) ?> href="index.php?req=resultat">Résultats</a></li>

        <?php if ($estAdmin): ?>
            <li><a<?= classe_active('admin', $req) ?> href="index.php?req=admin">Administrer</a></li>
        <?php endif; ?>

        <li><a href="index.php?req=logout">Déconnexion</a></li>
        <?php if (!empty($login)): ?>
            <li class="nom-utilisateur"><?= htmlspecialchars($login) ?></li>
        <?php endif; ?>
    </ul>
</nav>
