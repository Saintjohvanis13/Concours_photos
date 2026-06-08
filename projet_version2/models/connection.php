<?php
function connection() {
    require_once __DIR__ . '/../config/config.php';

    $dsn = 'mysql:host=' . HOST . ';dbname=' . DB . ';charset=utf8mb4';

    $connex = new PDO($dsn, USER, PASSWORD);
    $connex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connex->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $connex;
}
