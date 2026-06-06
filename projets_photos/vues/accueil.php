<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Concours photos</title>
    <link rel="stylesheet" href="objets/css/style.css">
</head>
<body class="fond-accueil">
    <main class="carte-accueil">
        <h1>Bienvenue sur le concours photos</h1>

<p>
    Vous êtes connecté avec le compte :
    <strong><?= htmlspecialchars($_SESSION['prenom'] . ' ' . $_SESSION['nom']) ?></strong>
</p>

<?php if ($concours): ?>

    <h2>Thème : <?= htmlspecialchars($concours['theme']) ?></h2>

    <p>
        <strong>Règlement :</strong><br>
        <?= nl2br(htmlspecialchars($concours['reglement'])) ?>
    </p>

    <h3>Dates importantes</h3>

    <ul>
        <li>Dépôt des photos : du <?= htmlspecialchars($concours['dateDebutDepot']) ?> au <?= htmlspecialchars($concours['dateFinDepot']) ?></li>
        <li>Vote : du <?= htmlspecialchars($concours['dateDebutVote']) ?> au <?= htmlspecialchars($concours['dateFinVote']) ?></li>
        <li>Résultats : <?= htmlspecialchars($concours['dateResultats']) ?></li>
    </ul>

    <h3>Prix</h3>

    <ul>
        <li>1er prix : <?= htmlspecialchars($concours['prix1']) ?> €</li>
        <li>2e prix : <?= htmlspecialchars($concours['prix2']) ?> €</li>
        <li>3e prix : <?= htmlspecialchars($concours['prix3']) ?> €</li>
    </ul>

<?php else: ?>

    <p>Aucun concours n’est encore configuré.</p>

<?php endif; ?>

<div class="actions-accueil">

    <?php if ($_SESSION['role'] === 'etudiant'): ?>
        <a href="index.php?action=depot_photo" class="bouton">Déposer une photo</a>
        <a href="index.php?action=vote" class="bouton">Voter</a>
    <?php endif; ?>

    <?php if ($_SESSION['role'] === 'personnel'): ?>
        <a href="index.php?action=vote" class="bouton">Voter</a>
    <?php endif; ?>

    <?php if ($_SESSION['role'] === 'administrateur'): ?>
        <a href="index.php?action=admin" class="bouton">Administration</a>
        <a href="index.php?action=resultats" class="bouton">Résultats</a>
    <?php endif; ?>

    <a href="index.php?action=deconnexion" class="bouton bouton-secondaire">Déconnexion</a>

</div>


    </main>
</body>
</html>

