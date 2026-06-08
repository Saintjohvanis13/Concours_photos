<?php require __DIR__ . '/header.php'; ?>
<main class="page">
    <h1>Mes photos</h1>
    <section class="photos">
        <?php foreach ($photos as $photo): ?>
            <article class="photo-card"><img src="<?= htmlspecialchars($photo['cheminFichier']) ?>" alt=""><h3><?= htmlspecialchars($photo['titre']) ?></h3><p><?= htmlspecialchars($photo['lieu']) ?> - <?= htmlspecialchars($photo['datePhoto']) ?></p><p>Statut : <?= htmlspecialchars($photo['statut']) ?></p><a class="danger" href="index.php?route=supprimer_photo&id=<?= $photo['idPhoto'] ?>">Supprimer</a></article>
        <?php endforeach; ?>
    </section>
</main>
<?php require __DIR__ . '/footer.php'; ?>
