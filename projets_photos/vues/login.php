<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Concours photos</title>
    <link rel="stylesheet" href="objets/css/style.css">
</head>
<body>
    <main class="page-connexion">
        <section class="panneau-gauche">
            <div class="bloc-texte">
                <h1>BIENVENUE SUR CONCOURS PHOTOS</h1>
                <p>
                    Pour accéder à ce site vous devez vous<br>
                    connecter avec les identifiants et le mot de passe<br>
                    d'Université de Poitiers.
                </p>
            </div>
        </section>

        <section class="panneau-droit">
            <div class="bloc-connexion">
                <div class="logo-universite">
                    <div class="blason">♜</div>
                    <div class="logo-ligne-1">Université</div>
                    <div class="logo-ligne-2">de Poitiers</div>
                </div>

                <?php if (!empty($erreur)): ?>
                    <p class="message-erreur"><?= htmlspecialchars($erreur) ?></p>
                <?php endif; ?>

                <form method="post" action="index.php" class="formulaire-connexion">
                    <input type="hidden" name="action" value="connexion">

                    <div class="champ">
                        <span class="icone">👤</span>
                        <input type="text" name="login" placeholder="Identifiant" required>
                    </div>

                    <div class="champ">
                        <span class="icone">🔒</span>
                        <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
                    </div>

                    <label class="souvenir">
                        <input type="checkbox" name="souvenir">
                        <span>Se souvenir de moi</span>
                    </label>

                    <button type="submit">Connexion</button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>
