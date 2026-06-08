<?php require __DIR__ . '/header.php'; ?>
<main class="page">
    <section class="hero">
        <div>
            <h1>Concours Photo<br>de l'IUT – site de Châtellerault<br>année 2026</h1>
            <p>Partagez vos plus beaux souvenirs de vacances estivales.</p>
        </div>
    </section>
    <section class="cartes">
        <article class="carte"><h3>Thème 2026</h3><p><?= htmlspecialchars($concours['theme'] ?? 'Vacances estivales') ?></p></article>
        <article class="carte"><h3>Dates importantes</h3><p>Dépôt : <?= htmlspecialchars($concours['dateDebutDepot'] ?? '') ?> au <?= htmlspecialchars($concours['dateFinDepot'] ?? '') ?></p><p>Vote : <?= htmlspecialchars($concours['dateDebutVote'] ?? '') ?> au <?= htmlspecialchars($concours['dateFinVote'] ?? '') ?></p></article>
        <article class="carte"><h3>Règlement</h3><p><?= nl2br(htmlspecialchars($concours['reglement'] ?? 'Une photo par étudiant.')) ?></p></article>
        <article class="carte"><h3>Prix</h3><p>1er : <?= htmlspecialchars($concours['prix1'] ?? '100') ?> €</p><p>2e : <?= htmlspecialchars($concours['prix2'] ?? '80') ?> €</p><p>3e : <?= htmlspecialchars($concours['prix3'] ?? '50') ?> €</p></article>
    </section>
    <p class="centre"><a class="bouton" href="index.php?route=connexion">Connectez-vous pour participer et voter</a></p>
</main>
<?php require __DIR__ . '/footer.php'; ?>
