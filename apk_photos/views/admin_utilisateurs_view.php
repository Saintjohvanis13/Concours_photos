<?php require('views/blocs/entete.php'); ?>

<main>
    <h1>Liste des utilisateurs</h1>

    <?php if (empty($etudiants)): ?>
        <p>Aucun utilisateur.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($etudiants as $etudiant): ?>
                <li>
                    <?= htmlspecialchars($etudiant['id']) ?> -
                    <?= htmlspecialchars($etudiant['login']) ?> -
                    <?= etudiant_est_administrateur($etudiant) ? 'admin' : 'étudiant' ?> -
                    <?= htmlspecialchars($etudiant['date']) ?> -
                    <?= etudiant_est_bloque($etudiant) ? 'bloqué' : 'autorisé' ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

            
 <a class="admin-btn admin-btn-retour" href="index.php?req=admin">Retour au tableau de bord</a>
    

</main>

<?php require('views/blocs/pied.php'); ?>
