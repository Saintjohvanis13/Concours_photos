<?php
session_start();
require_once("models/Admin.php");

function ctrl_admin() {


    $msg = null;
    $config = get_all_configuration();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach ($config as $param => $valeur_actuelle) {
            if (!empty($_POST[$param]) && $_POST[$param] != $valeur_actuelle) {
                update_configuration($param, $_POST[$param]);
                $config[$param] = $_POST[$param];
            }
        }
        $msg = "Dates mises à jour avec succès.";
    }

    include("views/admin_view.php");
}
