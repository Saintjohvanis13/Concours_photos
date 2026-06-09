<?php
header('Status: 404 Not Found', true, 404);
require('views/blocs/entete.php');
?>

<main class="page-simple">
    <h2>Page introuvable</h2>
    <div class="soulignement-orange"></div>
    <div class="carte-message">
        <p>La page demandée est introuvable.</p>
    </div>
    <a href="index.php?req=accueil" class="btn-retour">Retour à l’accueil</a>
</main>

<?php require('views/blocs/pied.php'); ?>
