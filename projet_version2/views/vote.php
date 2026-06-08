<?php require __DIR__ . '/header.php'; ?>
<main class="page">
    <h1>Phase de vote</h1>
    <p>Sélectionnez exactement 3 photos.</p>
    <?php if ($message): ?><p class="message"><?= htmlspecialchars($message) ?></p><?php endif; ?>
    <form method="post" action="index.php?route=vote">
        <section class="photos">
            <?php foreach ($photos as $photo): ?>
                <article class="photo-card vote-card"><label><img src="<?= htmlspecialchars($photo['cheminFichier']) ?>" alt=""><input type="checkbox" name="photos[]" value="<?= $photo['idPhoto'] ?>"><h3><?= htmlspecialchars($photo['titre']) ?></h3><p><?= htmlspecialchars($photo['lieu']) ?></p></label></article>
            <?php endforeach; ?>
        </section>
        <button type="submit">Confirmer mon vote</button>
    </form>
</main>
<?php require __DIR__ . '/footer.php'; ?>
