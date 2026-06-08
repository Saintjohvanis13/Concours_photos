<?php require __DIR__ . '/header.php'; ?>
<main class="page"><h1>Mes votes</h1><section class="photos"><?php foreach($photos as $photo): ?><article class="photo-card"><img src="<?= htmlspecialchars($photo['cheminFichier']) ?>"><h3><?= htmlspecialchars($photo['titre']) ?></h3><p><?= htmlspecialchars($photo['lieu']) ?></p></article><?php endforeach; ?></section></main>
<?php require __DIR__ . '/footer.php'; ?>
