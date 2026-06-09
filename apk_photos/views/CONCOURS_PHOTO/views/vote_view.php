<?php require("views/blocs/entete.php"); ?>

<main>
    <section class="vote-intro">
        <h2>Phase de vote</h2>
        <div class="soulignement-orange"></div>

        <?php if ($phase === 0): ?>
            <div class="carte-message">
                <p>Le vote n’est pas encore ouvert.</p>

            </div>
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
    </section>
</main>

<?php require("views/blocs/pied.php"); ?>
