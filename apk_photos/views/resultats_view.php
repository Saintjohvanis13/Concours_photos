<?php require('views/blocs/entete.php'); ?>

<main class="page-simple">
    <h2>Phase de résultats</h2>
    <div class="soulignement-orange"></div>

    <?php if ($photosTop3 === null): ?>
        <hr class="separateur">
        <a href="index.php?req=accueil" class="btn-retour">Retour à l’accueil</a>

    <?php elseif (empty($photosTop3)): ?>
        <div class="carte-message">
            <p>Aucune photo n’a encore reçu de votes.</p>
        </div>
        <hr class="separateur">
        <a href="index.php?req=accueil" class="btn-retour">Retour à l’accueil</a>

    <?php else: ?>
        <div class="cartes-info cartes-resultats">
            <?php foreach ($photosTop3 as $rang => $photo): ?>
                <?php
                    $description = htmlspecialchars($photo['description']);
                    $image = htmlspecialchars($photo['image']);
                    $votes = htmlspecialchars($photo['nb_votes']);
                ?>
                <div class="carte-info">
                    <strong><?= $rang + 1 ?>e place</strong>
                    <p><?= $description ?></p>
                    <img class="image-resultat" src="<?= $image ?>" alt="Photo">
                    <p>Nombre de votes : <?= $votes ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php require('views/blocs/pied.php'); ?>
