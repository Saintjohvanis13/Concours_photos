<?php require __DIR__ . '/header.php'; ?>
<main class="page petite-page">
    <section class="bloc-form">
        <h1>Connexion</h1>
        <p>Connectez-vous avec vos identifiants de l'Université.</p>

        <?php if (!empty($erreur)): ?>
            <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
        <?php endif; ?>

        <form method="post" action="index.php">
            <input type="hidden" name="route" value="connexion">

            <label for="login">Identifiant universitaire</label>
            <input type="text" id="login" name="login" autocomplete="username" required>

            <label for="pass">Mot de passe</label>
            <input type="password" id="pass" name="pass" autocomplete="current-password" required>

            <button type="submit">Se connecter</button>
        </form>
    </section>
</main>
<?php require __DIR__ . '/footer.php'; ?>
