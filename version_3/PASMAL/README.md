# Concours Photo 2026 - version simple corrigée

## Ce qui a été adapté

Le site garde le même contexte : concours photo de l'IUT de Châtellerault.
Les dates et les informations de la page d'accueil ont été adaptées au cahier des charges.

## Dates utilisées

- Dépôt des photos : du 07/09/2026 au 18/09/2026 inclus
- Vote : du 28/09/2026 au 03/10/2026 inclus
- Résultats : semaine 41

## Thème utilisé

Vacances estivales.

## Prix

- 1er prix : 100 €
- 2e prix : 80 €
- 3e prix : 50 €

## Correction importante

La colonne `description` ne bloque plus la connexion.
Quand un étudiant se connecte pour la première fois, une description vide est enregistrée automatiquement.

## Installation simple

1. Mettre le dossier dans `localhost`.
2. Créer la base `projet1_tp2` dans MariaDB.
3. Importer le fichier `database/base_de_donnees_structurées.sql`.
4. Ouvrir `index.php` dans le navigateur.
5. Se connecter avec un compte LDAP.

## Fichiers importants

- `views/accueil_view.php` : page d'accueil adaptée au cahier des charges.
- `database/base_de_donnees_structurées.sql` : base de données corrigée avec les bonnes dates.
- `controllers/AuthController.php` : connexion corrigée.
