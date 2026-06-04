<?php

/**
 * Crée une connexion PDO avec la base de données MySQL.
 * PDO = outil PHP qui permet de communiquer avec une base de données.
 *
 * @return PDO
 */
function connection() {
    require_once __DIR__ . '/../config/config.php';

    $dsn = 'mysql:host=' . HOST . ';dbname=' . DB . ';charset=utf8mb4';

    $connex = new PDO($dsn, USER, PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    return $connex;
}
