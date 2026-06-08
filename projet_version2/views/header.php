<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concours photo</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="entete">
    <a href="index.php?route=accueil" class="logo">IUT Châtellerault</a>
    <nav>
        <a href="index.php?route=accueil">Accueil</a>
        <?php if (est_connecte()): ?>
            <a href="index.php?route=espace">Mon espace</a>
            <a href="index.php?route=deconnexion">Déconnexion</a>
        <?php else: ?>
            <a href="index.php?route=connexion">Connexion</a>
        <?php endif; ?>
    </nav>
    <img src="images/logo_univ_poitiers.png" alt="Université de Poitiers" class="logo-univ">
</header>
