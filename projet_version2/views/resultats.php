<?php require __DIR__ . '/header.php'; ?>
<main class="page"><h1>Résultats du concours</h1><table><tr><th>Classement</th><th>Photo</th><th>Lieu</th><th>Votes</th></tr><?php $i=1; foreach($resultats as $r): ?><tr><td><?= $i++ ?></td><td><?= htmlspecialchars($r['titre']) ?></td><td><?= htmlspecialchars($r['lieu']) ?></td><td><?= $r['nbVotes'] ?></td></tr><?php endforeach; ?></table></main>
<?php require __DIR__ . '/footer.php'; ?>
