<?php
require("models/connection.php");

function get_all_configuration() {
    $pdo = connection();
    $stmt = $pdo->query("SELECT * FROM configuration");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $config = [];
    foreach ($results as $row) {
        $config[$row['parametre']] = $row['valeur'];
    }
    return $config;
}

function update_configuration($parametre, $valeur) {
    $pdo = connection();
    $stmt = $pdo->prepare("UPDATE configuration SET valeur = ? WHERE parametre = ?");
    $stmt->execute([$valeur, $parametre]);
}
