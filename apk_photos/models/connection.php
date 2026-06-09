<?php

/**
 * Crée une connexion PDO à la base de données.
 * PDO = objet PHP utilisé pour se connecter à une base SQL.
 * @return PDO
 */
function connexion_base_de_donnees() {
    // Charge les constantes HOST, DB, USER et PASSWORD depuis config.php.
    require('config/config.php');

    // Connexion à la base de données MariaDB/MySQL.
    $connex = new PDO('mysql:host=' . HOST . ';dbname=' . DB, USER, PASSWORD);
    return $connex;
}

// Ancien nom gardé pour éviter de casser un fichier qui appellerait encore connection().
function connection() {
    return connexion_base_de_donnees();
}


// Lors de la connexion réussie
//$_SESSION['user_id'] = $etudiant['id'];
//$_SESSION['is_admin'] = $etudiant['admin'] == 1;
