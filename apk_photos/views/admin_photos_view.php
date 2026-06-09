<?php require('views/blocs/entete.php'); ?>

<main>
    <h1>Photos</h1>

    <?php if (empty($photos)): ?>
        <p>Aucune photo.</p>
    <?php else: ?>
        <?php foreach ($photos as $photo): ?>
            <div>

                <img src="<?= htmlspecialchars($photo['chemin_affichage']) ?>" width="200">

                <p><?= htmlspecialchars($photo['nom_affiche']) ?></p>

                <form method="POST" action="index.php?req=modifier_photos">
                    <input type="hidden" name="action" value="supprimer">
                    <input type="hidden" name="id_photo" value="<?= $photo['id'] ?>">
                    <button type="submit">Supprimer</button>
                </form>

            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</main>

<?php require('views/blocs/pied.php'); ?>