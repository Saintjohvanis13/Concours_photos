<?php require("views/blocs/entete.php"); ?>

<main>
    <section class="vote-intro">
        <h2>Phase de vote</h2>
        <div class="soulignement-orange"></div>

        <?php if (isset($_SESSION['id']) && isset($_SESSION['login'])): ?>
            <p class="vote-user">
                Bienvenue, étudiant n°<?= $_SESSION['id'] ?> (<?= htmlspecialchars($_SESSION['login']) ?>)
            </p>
        <?php endif; ?>

        <?php if ($phase === 0): ?>
            <div class="carte-message">
                <p>Le vote n’est pas encore ouvert.</p>
                <p><strong>Il ouvrira le 28/09/2026 à 00h00.</strong></p>
            </div>
            <hr class="separateur">
            <p>Revenez à cette date pour voter.</p>
            <a href="index.php?req=accueil" class="btn-retour">Retour à l’accueil</a>
        <?php else: ?>
            <div class="carte-message">
                <p>
                    Phase <?= $phase ?> :
                    <?php if ($phase === 1): ?>
                        Vous pouvez voter pour <strong>3 photos différentes</strong>.
                    <?php else: ?>
                        Vous pouvez voter pour <strong>1 photo</strong> parmi les 10 meilleures.
                    <?php endif; ?>
                </p>
            </div>

            <?php if (!empty($error)): ?>
                <p class="p-error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
        <?php endif; ?>
    </section>

    <?php if ($phase !== 0): ?>
        <div class="photos-scroll-container">
            <?php foreach ($photoIds as $id): ?>
                <div class="photo-item">
                    <img src="photos/<?= htmlspecialchars($id) ?>.jpg" alt="photo <?= htmlspecialchars($id) ?>">
                    <form method="post">
                        <input type="hidden" name="vote_id" value="<?= htmlspecialchars($id) ?>">
                        <button type="submit" name="vote">Voter</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php require("views/blocs/pied.php"); ?>
