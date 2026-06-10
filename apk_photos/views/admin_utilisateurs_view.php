<?php require 'views/blocs/entete.php'; ?>

<main class="page-simple">
    <h1>Liste des participants</h1>

    <?php if (!empty($_SESSION['message_admin_utilisateurs'])): ?>
        <p class="message-ok"><?= htmlspecialchars($_SESSION['message_admin_utilisateurs']) ?></p>
        <?php unset($_SESSION['message_admin_utilisateurs']); ?>
    <?php endif; ?>

    <?php if (empty($etudiants)): ?>
        
    <?php else: ?>
        <ul>
            <?php foreach ($etudiants as $etudiant): ?>
                <li>
                    <?= (int)$etudiant['id'] ?> -
                    <?= htmlspecialchars($etudiant['login']) ?> -
                    <?= etudiant_est_administrateur($etudiant) ? 'admin' : 'étudiant' ?> -
                   
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <a class="admin-btn admin-btn-retour" href="index.php?req=admin">Retour au tableau de bord</a>
</main>

<?php require 'views/blocs/pied.php'; ?>
