<?php
require("models/connection.php");

function recuperer_toute_configuration() {
    $pdo = connexion_base_de_donnees();
    $stmt = $pdo->query("SELECT * FROM configuration");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $config = [];
    foreach ($results as $row) {
        $config[$row['parametre']] = $row['valeur'];
    }
    return $config;
}

function modifier_configuration($parametre, $valeur) {
    $pdo = connexion_base_de_donnees();
    $stmt = $pdo->prepare("UPDATE configuration SET valeur = ? WHERE parametre = ?");
    $stmt->execute([$valeur, $parametre]);
}

// Anciens noms gardés pour compatibilité.
function get_all_configuration() {
    return recuperer_toute_configuration();
}

function update_configuration($parametre, $valeur) {
    modifier_configuration($parametre, $valeur);
}
