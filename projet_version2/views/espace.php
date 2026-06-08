<?php require __DIR__ . '/header.php'; ?>
<main class="page">
    <h1>Mon espace</h1>
    <p>Bienvenue, <?= htmlspecialchars($_SESSION['prenom'] ?? '') ?>.</p>
    <section class="grille-menu">
        <a class="tuile" href="index.php?route=depot_photo"><h2>Participer</h2><p>Déposer ma photo</p></a>
        <a class="tuile" href="index.php?route=vote"><h2>Voter</h2><p>Voir les photos et voter</p></a>
        <a class="tuile" href="index.php?route=mes_photos"><h2>Mes photos</h2><p>Gérer mes photos</p></a>
        <a class="tuile" href="index.php?route=mes_votes"><h2>Mes votes</h2><p>Voir mes votes</p></a>
        <?php if (est_admin()): ?><a class="tuile" href="index.php?route=admin"><h2>Administration</h2><p>Gérer le concours</p></a><?php endif; ?>
    </section>
</main>
<?php require __DIR__ . '/footer.php'; ?>
