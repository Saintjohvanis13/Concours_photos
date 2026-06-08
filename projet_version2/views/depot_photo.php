<?php require __DIR__ . '/header.php'; ?>
<main class="page petite-page">
    <section class="bloc-form">
        <h1>Déposer ma photo</h1>
        <?php if ($message): ?><p class="message"><?= htmlspecialchars($message) ?></p><?php endif; ?>
        <form method="post" action="index.php?route=depot_photo" enctype="multipart/form-data">
            <label>Titre de la photo</label><input type="text" name="titre" required>
            <label>Lieu</label><input type="text" name="lieu" required>
            <label>Date de prise de vue</label><input type="date" name="datePhoto" required>
            <label>Sélectionner votre photo</label><input type="file" name="photo" accept="image/*" required>
            <button type="submit">Envoyer ma photo</button>
        </form>
    </section>
</main>
<?php require __DIR__ . '/footer.php'; ?>
