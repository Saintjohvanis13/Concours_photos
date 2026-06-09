<?php require('views/blocs/entete.php'); ?>

<main class="page-simple">
    <h2><?= htmlspecialchars($titrePage ?? 'Concours') ?></h2>
    <div class="soulignement-orange"></div>

    <div class="carte-message">
        <p><strong>Concours non accessible.</strong></p>
        <p><?= htmlspecialchars($messagePage ?? 'Cette partie est réservée aux administrateurs.') ?></p>
    </div>

    <hr class="separateur">
    <a href="index.php?req=accueil" class="btn-retour">Retour à l’accueil</a>
</main>

<?php require('views/blocs/pied.php'); ?>
