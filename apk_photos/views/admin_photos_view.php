<?php require 'views/blocs/entete.php'; ?>  // génerer strucutre de la page

<main class="page-simple">
    <h1>Photos déposées</h1>

    <?php if (!empty($_SESSION['message_admin_photos'])): ?>    //affichage des messages 
        <p class="message-ok"><?= htmlspecialchars($_SESSION['message_admin_photos']) ?></p>
        <?php unset($_SESSION['message_admin_photos']); ?>
    <?php endif; ?>

    <?php if (empty($photos)): ?>  //verifier contenu des photos
        <p>Aucune photo déposée.</p>
    <?php else: ?>
        <?php foreach ($photos as $photo): ?>    //afficher les photos avec image et nom
            <div class="carte-message">
                <img src="<?= htmlspecialchars($photo['chemin_affichage']) ?>" width="200" alt="Photo du concours">
                <p><?= htmlspecialchars($photo['nom_affiche']) ?></p>

                <form method="POST" action="index.php?req=modifier_photos">  //formulaire de suppression
                    <input type="hidden" name="action" value="supprimer">     //envoyer les infos au controleur pour lui dire de supprimer 
                    <input type="hidden" name="id_photo" value="<?= (int)$photo['id'] ?>">
                    <input type="hidden" name="nom_fichier" value="<?= htmlspecialchars($photo['nom_fichier'] ?? '') ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <a class="admin-btn admin-btn-retour" href="index.php?req=admin">Retour au tableau de bord</a>
</main>

<?php require 'views/blocs/pied.php'; ?>
