<?php require('views/blocs/entete.php'); ?>

<main class="depot-page">
    <h1>Phase de dépôt</h1>
    <div class="soulignement-orange"></div>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="message"><?= htmlspecialchars($_SESSION['message']) ?><?php unset($_SESSION['message']); ?></div>
    <?php endif; ?>

    <div class="carte-message">
        <p><strong>Déposez votre photo pour le concours.</strong></p>
        <p>Votre photo doit respecter le thème : <strong>Vacances estivales</strong>.</p>
    </div>

    <div class="zone-upload" id="zone-upload">
        <img id="aperçu-photo" src="" alt="Aperçu" hidden>
        <input type="file" name="photo" id="input-photo" accept="image/*" hidden>
        <button id="btn-choisir" type="button">Choisir une photo</button>
    </div>

    <form id="form-photo" method="POST" action="index.php?req=depot" enctype="multipart/form-data">
        <input type="file" name="photo" accept="image/*" required>
        <textarea name="description" placeholder="Description de la photo" required></textarea>
        <button type="submit">Déposer la photo</button>
    </form>
</main>

<?php require('views/blocs/pied.php'); ?>
