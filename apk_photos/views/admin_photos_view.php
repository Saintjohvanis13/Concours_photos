<?php require("views/blocs/entete.php"); ?>

<main class="page-contenu admin-photos-page">
    <h1 class="titre-page">Gestion des photos</h1>
    <div class="soulignement-orange" style="margin-left:0;"></div>

    <?php if (isset($msg)): ?>
        <p class="message-ok"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <div class="photos-admin">
        <?php foreach ($etudiants as $etudiant): ?>
            <?php
                $photoPath = "photos/{$etudiant['id']}.jpg";
                if (!file_exists($photoPath)) continue;
            ?>
            <div class="photo-admin-card">
                <img src="<?= $photoPath ?>" alt="Photo <?= htmlspecialchars($etudiant['id']) ?>">
                <form method="post" action="index.php?req=admin_photos" onsubmit="return confirm('Supprimer cette photo ?');">
                    <input type="hidden" name="id_etudiant" value="<?= htmlspecialchars($etudiant['id']) ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<style>
.admin-photos-page {
    margin-top: 50px;
    margin-bottom: 90px;
}
.photos-admin {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
    gap: 24px;
}
.photo-admin-card {
    background: #fff;
    border: 1px solid #d7e2f3;
    border-radius: 8px;
    padding: 14px;
    text-align: center;
    box-shadow: 0 4px 18px rgba(0, 40, 120, 0.05);
}
.photo-admin-card img {
    width: 100%;
    height: 155px;
    object-fit: cover;
    border-radius: 6px;
    margin-bottom: 12px;
}
.photo-admin-card button { width: 100%; }
</style>

<?php require("views/blocs/pied.php"); ?>
