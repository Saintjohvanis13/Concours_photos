<?php require("views/blocs/entete.php"); ?>

<main class="admin-page">
    <aside class="admin-menu">
        <a class="active" href="index.php?req=admin">Tableau de bord</a>
        <a href="#dates">Dates du concours</a>
        <a href="#infos">Informations accueil</a>
        <a href="index.php?req=admin_photos">Photos déposées</a>
        <a href="#utilisateurs">Utilisateurs</a>
        <a href="index.php?req=resultat">Résultats</a>
        <a href="index.php?req=logout">Déconnexion</a>
    </aside>

    <section class="admin-contenu">
        <h1>Tableau de bord</h1>
        <div class="admin-soulignement"></div>

        <?php if (isset($msg)) echo "<p class='message-ok'>" . htmlspecialchars($msg) . "</p>"; ?>

        <div class="admin-grid">
            <div class="admin-card">
                <h2>Récapitulatif</h2>
                <p><strong>Dépôt des photos</strong><br>Le dépôt des photos dépend des dates configurées.</p>
                <p><strong>Vote</strong><br>La phase de vote dépend des dates configurées.</p>
                <p><strong>Résultats</strong><br>Les résultats seront affichés selon les dates configurées.</p>
            </div>

            <div class="admin-card stats-card">
                <h2>Statistiques</h2>
                <p><strong>Photos déposées</strong><br><span>0</span></p>
                <p><strong>Votes enregistrés</strong><br><span>0</span></p>
                <p><strong>Utilisateurs inscrits</strong><br><span>0</span></p>
            </div>
        </div>

        <div class="admin-card actions-card">
            <h2>Actions rapides</h2>
            <div class="actions-ligne">
                <a class="admin-btn" href="#dates">Modifier les dates</a>
                <a class="admin-btn" href="#infos">Modifier les informations</a>
                <a class="admin-btn" href="index.php?req=admin_photos">Voir les photos</a>
                <a class="admin-btn" href="#utilisateurs">Voir les utilisateurs</a>
            </div>
        </div>

        <div class="admin-card" id="dates">
            <h2>Modifier les dates</h2>
            <form method="post" action="index.php?req=admin" class="admin-form">
                <?php foreach ($config as $param => $valeur): ?>
                    <label for="<?= htmlspecialchars($param) ?>">
                        <?= htmlspecialchars(ucfirst(str_replace('_', ' ', $param))) ?>
                        <input type="text" id="<?= htmlspecialchars($param) ?>" name="<?= htmlspecialchars($param) ?>" placeholder="AAAA-MM-JJ" value="<?= htmlspecialchars($valeur) ?>">
                    </label>
                <?php endforeach; ?>

                <button type="submit">Mettre à jour</button>
            </form>
        </div>
    </section>
</main>

<style>
.admin-page {
    width: 100%;
    margin: 0;
    display: grid;
    grid-template-columns: 255px 1fr;
    min-height: calc(100vh - 158px);
}
.admin-menu {
    background: #fbfdff;
    border-right: 1px solid #d7e2f3;
    padding: 42px 26px;
}
.admin-menu a {
    display: block;
    padding: 14px 16px;
    color: #061b5f;
    text-decoration: none;
    border-radius: 7px;
    margin-bottom: 12px;
    font-size: 15px;
}
.admin-menu a.active,
.admin-menu a:hover {
    background: #eaf2ff;
    color: #003aa0;
    font-weight: 800;
}
.admin-contenu {
    padding: 42px min(5vw, 58px) 64px;
}
.admin-contenu h1 {
    color: #003aa0;
    margin: 0;
    font-size: 40px;
    font-weight: 900;
}
.admin-soulignement {
    width: 56px;
    height: 3px;
    background: #ff6b00;
    margin: 18px 0 30px;
}
.admin-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 28px;
    margin-bottom: 28px;
}
.admin-card {
    background: #fff;
    border: 1px solid #d7e2f3;
    border-radius: 8px;
    padding: 26px;
    box-shadow: 0 4px 18px rgba(0, 40, 120, 0.05);
}
.admin-card h2 {
    color: #003aa0;
    font-size: 22px;
    margin: 0 0 22px;
}
.admin-card p {
    line-height: 1.7;
    margin: 0 0 20px;
}
.stats-card p {
    border-bottom: 1px solid #d7e2f3;
    padding-bottom: 16px;
}
.stats-card p:last-child { border-bottom: 0; }
.stats-card span {
    display: inline-block;
    color: #003aa0;
    font-size: 28px;
    font-weight: 900;
    margin-top: 6px;
}
.actions-card { margin-bottom: 28px; }
.actions-ligne {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
}
.admin-btn {
    display: inline-block;
    text-align: center;
    border: 1px solid #2f74e8;
    color: #003aa0;
    background: #fff;
    padding: 13px 14px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 700;
}
.admin-btn:hover {
    background: #eaf2ff;
}
.admin-form {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
}
.admin-form label {
    display: flex;
    flex-direction: column;
    gap: 8px;
    font-weight: 700;
    font-size: 14px;
}
.admin-form button { align-self: end; }
@media (max-width: 900px) {
    .admin-page, .admin-grid, .actions-ligne { grid-template-columns: 1fr; }
    .admin-menu { border-right: 0; padding: 24px; }
}
</style>

<?php require("views/blocs/pied.php"); ?>
