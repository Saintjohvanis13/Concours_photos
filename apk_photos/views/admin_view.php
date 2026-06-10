<?php require 'views/blocs/entete.php'; ?>

<main class="admin-page">
    <section class="admin-contenu">
        <h1>Gestion administrateur</h1>
        <div class="admin-soulignement"></div>

        <div class="admin-card actions-card">
            <h2>Actions disponibles</h2>

            <div class="actions-ligne actions-ligne-5">
                <a class="admin-btn" href="index.php?req=depot">Déposer une photo</a>
                <a class="admin-btn" href="index.php?req=vote">Voter</a>
                <a class="admin-btn" href="index.php?req=resultat">Voir les résultats</a>
                <a class="admin-btn" href="index.php?req=modifier_photos">Voir les photos</a>
                <a class="admin-btn" href="index.php?req=utilisateurs_admin">Voir les participants</a>
            </div>
        </div>
    </section>
</main>

<?php require 'views/blocs/pied.php'; ?>
