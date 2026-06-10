<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Concours Photos</title>
    <link rel="stylesheet" href="public/css/style_log_acc.css">
</head>
<body class="login-body">

<header class="login-header">
    <img src="public/images/logo-iut.png" alt="Logo IUT de Châtellerault" class="login-logo-univ">
</header>

<main class="login-wrapper">
    <section class="login-box">
        <h1>Connexion</h1>
        <div class="login-line"></div>

        <p class="login-intro">
            Bienvenue sur le concours photo du site de Châtellerault de l’Université de Poitiers.<br>
            Connectez-vous avec vos identifiants de l’ENT.
        </p>

        <form method="POST" action="index.php?req=login">
            <input type="text" name="login" placeholder="Identifiant" required>
            <input type="password" name="pass" placeholder="Mot de passe" required>

            <?php if (!empty($error)): ?>
                <p class="error-msg"><?= $error ?></p>
            <?php endif; ?>

            <button type="submit" class="login-btn">Se connecter</button>
        </form>
    </section>
</main>

<footer class="login-footer">
    <img src="public/images/logo-iut.png" alt="Logo IUT de Châtellerault" class="login-footer-logo">
</footer>

</body>
</html>
