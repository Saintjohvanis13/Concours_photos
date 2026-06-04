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
        <p>Vous pouvez maintenant accéder aux fonctionnalités du site.</p>
        <a class="lien-deconnexion" href="index.php?action=deconnexion">Déconnexion</a>
    </main>
</body>
</html>
