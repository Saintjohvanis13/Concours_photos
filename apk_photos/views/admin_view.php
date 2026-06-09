<?php require("views/blocs/entete.php"); ?>

<main class="admin-page">
    <section class="admin-contenu">
        <h1>Gestion administrateur</h1>
        <div class="admin-soulignement"></div>

        <?php if (isset($msg)) echo "<p class='message-ok'>" . htmlspecialchars($msg) . "</p>"; ?>

        <div class="admin-card actions-card">
            <h2>Actions de l'administrateur</h2>


            <div class="actions-ligne actions-ligne-5">
                <a class="admin-btn" href="#dates">Modifier les dates</a>
                <a class="admin-btn" href="#accueil">Modifier le thème</a>
                <a class="admin-btn" href="#accueil">Modifier l'accueil</a>
                <a class="admin-btn" href="index.php?req=modifier_photos">Voir photos</a>
                <a class="admin-btn" href="index.php?req=utilisateurs_admin">Voir les Participants</a>
            </div>
    
    </section>
</main>

<?php require("views/blocs/pied.php"); ?>
